<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <title>XML PHP</title>
    </head>
    <body>
<?php
class XmlCrud {
    private $xmlFile;

    public function __construct($xmlFile) {
        $this->xmlFile = $xmlFile;
    }

    public function create($data) {
        $xml = simplexml_load_file($this->xml_file);
        $new_data = $xml->addChild('data');
        foreach ($data as $key => $value) {
            $new_data->addChild($key, $value);
        }
        $xml->asXML($this->xml_file);
    }

    public function read() {
        return simplexml_load_file($this->xmlFile);
    }

    public function update($id, $data) {
        $xml = simplexml_load_file($this->xmlFile);
        foreach ($xml->children() as $item) {
            if ((int)$item->id == $id) {
                foreach ($data as $key => $value) {
                    $item->$key = $value;
                }
            }
        }
        $xml->asXML($this->xmlFile);
    }

    public function delete($id) {
        $xml = simplexml_load_file($this->xmlFile);
        foreach ($xml->children() as $key => $item) {
            if ((int)$item->id == $id) {
                unset($xml->data[$key]);
            }
        }
        $xml->asXML($this->xmlFile);
    }
}

// Exemplo de uso:

$xml_crud = new XML_CRUD('data.xml');

// Criar um novo registro
$new_data = array(
    'id' => 1,
    'name' => 'John Doe',
    'email' => 'john@example.com'
);
$xml_crud->create($new_data);

// Ler todos os registros
$data = $xml_crud->read();
foreach ($data->children() as $item) {
    echo "ID: " . $item->id . ", Name: " . $item->name . ", Email: " . $item->email . "<br>";
}

// Atualizar um registro
$update_data = array(
    'name' => 'Jane Doe',
    'email' => 'jane@example.com'
);
$xml_crud->update(1, $update_data);

// Excluir um registro
$xml_crud->delete(1);
?>
    </body>
</html>