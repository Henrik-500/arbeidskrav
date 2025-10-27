<?php  /* registrer-Student */
/*
/*  Programmet lager et html-skjema for å registrere en Student
/*  Programmet registrerer data (brukernavn, fornavn, etternavn og klassekode) i databasen
*/
?> 

<h3>Registrer student </h3>

<form method="post" action="" id="registrerStudentSkjema" name="registrerStudentSkjema">
  Brukernavn <input type="text" id="brukernavn" name="brukernavn" required /> <br/>
  Fornavn <input type="text" id="fornavn" name="fornavn" required /> <br/>
  Etternavn <input type="text" id="etternavn" name="etternavn" required /> <br/>
  klassekode <select id="klassekode" name="klassekode" required>
  <?php
    // Hent liste over klasser dynamisk fra DB
    include_once("db-tilkobling.php"); // bruk include_once så den ikke lastes to ganger
    $sql = "SELECT klassekode, klassenavn FROM klasse ORDER BY klassekode";
    $res = mysqli_query($db, $sql) or die("ikke mulig &aring; hente data fra databasen");

    if (mysqli_num_rows($res) === 0) {
      // Valgfritt: Vis en "tom" option hvis det ikke finnes klasser
      echo "<option value='' disabled selected>Ingen klasser registrert</option>";
    } else {
      while ($rad = mysqli_fetch_assoc($res)) {
        $kode = htmlspecialchars($rad['klassekode']);
        $navn = htmlspecialchars($rad['klassenavn']);
        echo "<option value='$kode'>$kode – $navn</option>";
      }
    }
  ?>
</select>
<br/>
  <input type="submit" value="Registrer student" id="registrerStudentKnapp" name="registrerStudentKnapp" /> 
  <input type="reset" value="Nullstill" id="nullstill" name="nullstill" /> <br />
</form>

<?php 
  if (isset($_POST ["registrerStudentKnapp"]))
    {
      $brukernavn=$_POST ["brukernavn"];
      $fornavn=$_POST ["fornavn"];
      $etternavn=$_POST ["etternavn"];
      $klassekode=$_POST ["klassekode"];

      if (!$brukernavn || !$fornavn || !$etternavn || !$klassekode)
        {
          print ("Brukernavn,Fornavn, Etternavn og Klassekode m&aring; fylles ut");
        }
      else
        {
          include("db-tilkobling.php");  /* tilkobling til database-serveren utført og valg av database foretatt */

          $sqlSetning="SELECT * FROM student WHERE brukernavn='$brukernavn';";
          $sqlResultat=mysqli_query($db,$sqlSetning) or die ("ikke mulig &aring; hente data fra databasen");
          $antallRader=mysqli_num_rows($sqlResultat); 

          if ($antallRader!=0)  /* Studenten er registrert fra før */
            {
              print ("Student er registrert fra f&oslashr");
            }
          else
            {
              $sqlSetning="INSERT INTO student VALUES('$brukernavn','$fornavn','$etternavn','$klassekode');";
              mysqli_query($db,$sqlSetning) or die ("ikke mulig &aring; registrere data i databasen");
                /* SQL-setning sendt til database-serveren */

              print ("F&oslash;lgende student er n&aring; registrert: $fornavn $etternavn"); 
            }
        }
    }
?> 
<br><br>
<p><a href="index.html"> Tilbake til brukerfunksjoner</a></p>