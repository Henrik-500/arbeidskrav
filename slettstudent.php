<?php  /* slett-klasse */
/*
/*  Programmet lager et skjema for å velge en klasse som skal slettes  
/*  Programmet sletter den valgte klassen
*/
?> 

<script src="funksjoner.js"> </script>

<h3>Slett klasse</h3>

<form method="post" action="" id="slettStudentSkjema" name="slettStudentSkjema" onSubmit="return bekreft()">
 Brukernavn
<select id="brukernavn" name="brukernavn" required>
  <?php
    // Hent liste over klasser dynamisk fra DB
    include_once("db-tilkobling.php"); // bruk include_once så den ikke lastes to ganger
    $sql = "SELECT brukernavn, fornavn, etternavn FROM student ORDER BY brukernavn";
    $res = mysqli_query($db, $sql) or die("ikke mulig &aring; hente data fra databasen");

    if (mysqli_num_rows($res) === 0) {
      // Valgfritt: Vis en "tom" option hvis det ikke finnes klasser
      echo "<option value='' disabled selected>Ingen student registrert</option>";
    } else {
      while ($rad = mysqli_fetch_assoc($res)) {
        $kode = htmlspecialchars($rad['brukernavn']);
        $fnavn = htmlspecialchars($rad['fornavn']);
        $enavn = htmlspecialchars($rad['etternavn']);
        echo "<option value='$kode'>$kode – $fnavn</option>";
      }
    }
  ?>
</select>
<br/>
  <input type="submit" value="Slett student" name="slettStudentKnapp" id="slettStudentKnapp" /> 
</form>

<?php
  if (isset($_POST ["slettStudentKnapp"]))
    {	
      $brukernavn=$_POST ["brukernavn"];
	  
	  if (!$brukernavn)
        {
          print ("brukernavn m&aring; fylles ut");
        }
      else
        {
          include("db-tilkobling.php");  /* tilkobling til database-serveren utført og valg av database foretatt */

          $sqlSetning="SELECT * FROM student WHERE brukernavn='$brukernavn';";
          $sqlResultat=mysqli_query($db,$sqlSetning) or die ("ikke mulig &aring; hente data fra databasen");
          $antallRader=mysqli_num_rows($sqlResultat); 

          if ($antallRader==0)  /* studenten er ikke registrert */
            {
              print ("Brukernavn finnes ikke");
            }
          else
            {	  
              $sqlSetning="DELETE FROM student WHERE brukernavn='$brukernavn';";
              mysqli_query($db,$sqlSetning) or die ("ikke mulig &aring; slette data i databasen");
                /* SQL-setning sendt til database-serveren */
		
              print ("F&oslash;lgende student er n&aring; slettet: $brukernavn <br />");
            }
        }
    }
?> 
<br><br>
<p><a href="index.html"> Tilbake til brukerfunksjoner</a></p>