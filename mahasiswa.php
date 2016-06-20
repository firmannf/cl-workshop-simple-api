<?php
    include "connection.php";

    $request = $_SERVER['REQUEST_METHOD'];
    
   if($request === "GET") {
        if(isset($_GET['nim'])){
            $nim = $_GET['nim'];
            $sql = "SELECT * FROM mahasiswa WHERE NIM = $nim";
        } else if(isset($_GET['nama'])){
            $nama = $_GET['nama'];
            $sql = "SELECT * FROM mahasiswa WHERE Nama = '$nama'";
        } else
            $sql = "SELECT * FROM mahasiswa";
        
        $query = mysqli_query($connection, $sql);
        
        $item = array();
        while($data = mysqli_fetch_array($query)){
            $item[] = array(
                'NIM' => $data['NIM'],
                'Nama' => $data['Nama']
            );
        }
        
        $json = array(
            'statusCode' => 200,
            'item' => $item
        );
        
        echo json_encode($json);
    } else if($request === "POST") {
        if(isset($_POST['nim']) && isset($_POST['nama'])){
            $nim = $_POST['nim'];
            $nama = $_POST['nama'];
            
            $sql = "INSERT INTO mahasiswa(Nim, Nama) VALUES('$nim', '$nama')";            
            $query = mysqli_query($connection, $sql);
            
            if(mysqli_affected_rows($connection) > 0){
                $sql = "SELECT * FROM mahasiswa WHERE nim = $nim";
                $query = mysqli_query($connection, $sql);
                
                $item = array();
                while($data = mysqli_fetch_array($query)) {
                    $item[] = array(
                        'nim' => $data['NIM'],
                        'nama' => $data['Nama']
                    );
                }
                $json = array(
                    'statusCode' => 200,
                    'message' => "Berhasil Tambah Data",
                    'item' => $item
                );
            } else{            
                $json = array(
                    'statusCode' => 400,
                    'message' => "Gagal Tambah Data"
                );
            }
        }
        
        echo json_encode($json);
    }else if($request === "PUT"){
        $_PUT = array();
        parse_str(file_get_contents('php://input'), $_PUT);
        if(isset($_GET['nim']) && isset($_PUT['nama'])){
            $nim = $_GET['nim'];
            $nama = $_PUT['nama'];
            
            $sql = "UPDATE mahasiswa SET Nama='$nama' WHERE Nim='$nim'";            
            $query = mysqli_query($connection, $sql);
            
            if(mysqli_affected_rows($connection) > 0){
                $sql = "SELECT * FROM mahasiswa WHERE nim = $nim";
                $query = mysqli_query($connection, $sql);
                
                $item = array();
                while($data = mysqli_fetch_array($query)) {
                    $item[] = array(
                        'nim' => $data['NIM'],
                        'nama' => $data['Nama']
                    );
                }
                $json = array(
                    'statusCode' => 200,
                    'message' => "Berhasil Update Data",
                    'item' => $item
                );
            } else{            
                $json = array(
                    'statusCode' => 400,
                    'message' => "Gagal Update Data"
                );
            }
        }
        
        echo json_encode($json);
    }else if($request === "DELETE"){
        if(isset($_GET['nim'])){
            $nim = $_GET['nim'];
            
            $sql = "DELETE FROM mahasiswa WHERE Nim='$nim'";            
            $query = mysqli_query($connection, $sql);
            
            if(mysqli_affected_rows($connection) > 0){
                
                $item = array(
                    'nim' => $nim,
                );
                $json = array(
                    'statusCode' => 200,
                    'message' => "Berhasil Hapus Data",
                    'item' => $item
                );
            } else{            
                $json = array(
                    'statusCode' => 400,
                    'message' => "Gagal Hapus Data"
                );
            }
        }
        
        echo json_encode($json);
    }
?>