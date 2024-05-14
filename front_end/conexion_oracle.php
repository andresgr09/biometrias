<?php


$username7 = "MIGRACION";
$password7 = "PcM1gR4ELD01";
$host7="migeld-cluster.migracioncolombia.local/MIGELD";
class aerdorado {
    private $conn;

    public function __construct($username7, $password7, $host7) {
        $this->conn = oci_connect($username7, $password7, $host7);
        
        if (!$this->conn) {
            throw new Exception("Error de conexion o base de datos caida");
        }
        else{
            echo "conexion hecha";
        }
    }
 
    public function executeQuery($sql7) {
        $stid = oci_parse($this->conn, $sql7);
        oci_execute($stid);

        $results = [];
        while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
            $results[] = $row;
        }

        oci_free_statement($stid);
        return $results;
    }

    public function closeConnection() {
        oci_close($this->conn);
    }
}





?>