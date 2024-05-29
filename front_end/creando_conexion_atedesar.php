<?php



class atedesar {
    private $conn;

    public function __construct($userprueba, $passwordprueba, $hostprueba) {
        $this->conn = oci_connect($userprueba, $passwordprueba, $hostprueba);
        if (!$this->conn) {
            $e = oci_error();
            throw new Exception("Error de conexión : " . $e['message']);
        }
    }

    public function executePLSQL($plsql, $numeros) {
        $stid = oci_parse($this->conn, $plsql);
        oci_bind_by_name($stid, ":numeros", $numeros);
        if (!oci_execute($stid)) {
            $e = oci_error($stid);
            throw new Exception("Error al ejecutar el PL/SQL: " . $e['message']);
        }

        $messages = $this->getDbmsOutput();
        oci_free_statement($stid);

        return $messages;
    }

    private function getDbmsOutput() {
        oci_execute(oci_parse($this->conn, 'BEGIN DBMS_OUTPUT.ENABLE(NULL); END;'));

        $output = [];
        $stid = oci_parse($this->conn, 'BEGIN DBMS_OUTPUT.GET_LINE(:line, :status); END;');
        oci_bind_by_name($stid, ':line', $line, 32767);
        oci_bind_by_name($stid, ':status', $status);

        while (true) {
            oci_execute($stid);
            if ($status != 0) {
                break;
            }
            $output[] = $line;
        }

        return $output;
    }

    public function closeConnection() {
        oci_close($this->conn);
    }
}
?>
