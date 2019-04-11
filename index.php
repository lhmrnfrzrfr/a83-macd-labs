<html>
 <head>
 <Title>Form Registrasi</Title>
 <style type="text/css">
 	body { background-color: #fff; border-top: solid 10px #000;
 	    color: #333; font-size: .85em; margin: 20; padding: 20;
 	    font-family: "Segoe UI", Verdana, Helvetica, Sans-Serif;
 	}
 	h1, h2, h3,{ color: #000; margin-bottom: 0; padding-bottom: 0; }
 	h1 { font-size: 2em; }
 	h2 { font-size: 1.75em; }
 	h3 { font-size: 1.2em; }
 	table { margin-top: 0.75em; }
 	th { font-size: 1.2em; text-align: left; border: none; padding-left: 19; }
 	td { padding: 0.25em 5em 0.50em 1em; border: 0 none; }
 </style>
 </head>
 <body>
 <h1>Daftar Seminar Segera!</h1>
 <p>Tulis form diabawah dengan data dirimu, kemudian klik <strong>Submit</strong> untuk mendaftar.</p>
 <form method="post" action="index.php" enctype="multipart/form-data" >
       NIM  <input type="text" name="nim" id="nim" required/></br></br>
       Name  <input type="text" name="name" id="name" required/></br></br>
       Email <input type="email" name="email" id="email" required/></br></br>
       Jurusan <input type="text" name="jurusan" id="jurusan" required/></br></br>
       <input type="submit" name="submit" value="Submit" />
       <button type="submit" name="load_data" value="Load Data"></button>
 </form>
 <?php
    $host = "lhmrnfrzrfrserver.database.windows.net,1433";
    $user = "lhmrnfrzrfr";
    $pass = "Anotherlife2";
    $db = "lhmrnfrzrfrdb";

    try {
        $conn = new PDO("sqlsrv:server = $host; Database = $db", $user, $pass);
        $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    } catch(Exception $e) {
        echo "Failed: " . $e;
    }

    if (isset($_POST['submit'])) {
        try {
            $nim = $_POST['nim'];
            $name = $_POST['name'];
            $email = $_POST['email'];
            $jurusan = $_POST['jurusan'];
            $date = date("Y-m-d");
            // Insert data
            $sql_insert = "INSERT INTO Registration (nim, name, email, jurusan, date) 
                        VALUES (?,?,?,?,?)";
            $stmt = $conn->prepare($sql_insert);
            $stmt->bindValue(1, $nim);
            $stmt->bindValue(2, $name);
            $stmt->bindValue(3, $email);
            $stmt->bindValue(4, $jurusan);
            $stmt->bindValue(5, $date);
            $stmt->execute();
        } catch(Exception $e) {
            echo "Failed: " . $e;
        }

        echo "<h3>Kamu berhasil mendaftar!</h3>";
    } else if (isset($_POST['load_data'])) {
        try {
            $sql_select = "SELECT * FROM Registration";
            $stmt = $conn->query($sql_select);
            $registrants = $stmt->fetchAll(); 
            if(count($registrants) > 0) {
                echo "<h2>Mahasiswa yang telah terdaftar:</h2>";
                echo "<table>";
                echo "<tr><th>NIM</th>";
                echo "<th>Nama Lengkap</th>";
                echo "<th>Email</th>";
                echo "<th>Jurusan</th>";
                echo "<th>Date</th></tr>";
                foreach($registrants as $registrant) {
                    echo "<tr><td>".$registrant['nim']."</td>";
                    echo "<td>".$registrant['name']."</td>";
                    echo "<td>".$registrant['email']."</td>";
                    echo "<td>".$registrant['jurusan']."</td>";
                    echo "<td>".$registrant['date']."</td></tr>";
                }
                echo "</table>";
            } else {
                echo "<h3>No one is currently registered.</h3>";
            }
        } catch(Exception $e) {
            echo "Gagal mendaftar, karena : " . $e;
        }
    }
 ?>
 </body>
 </html>