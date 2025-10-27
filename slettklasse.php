<?php  /* slett-klasse */
/*
/*  Programmet lager et skjema for å velge en klasse som skal slettes  
/*  Programmet sletter den valgte klassen
*/
?> 

<script src="funksjoner.js"> </script>

<h3>Slett klasse</h3>

<form method="post" action="" id="slettKlasseSkjema" name="slettKlasseSkjema" onSubmit="return bekreft()">
 Klassekode
<select id="klassekode" name="klassekode" required>
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
  <input type="submit" value="Slett klassekode" name="slettKlasseKnapp" id="slettKlasseKnapp" /> 
</form>

<?php
  if (isset($_POST ["slettKlasseKnapp"]))
    {	
      $klassekode=$_POST ["klassekode"];
	  
	  if (!$klassekode)
        {
          print ("klassekode m&aring; fylles ut");
        }
      else
        {
          include("db-tilkobling.php");  /* tilkobling til database-serveren utført og valg av database foretatt */

          $sqlSetning="SELECT * FROM klasse WHERE klassekode='$klassekode';";
          $sqlResultat=mysqli_query($db,$sqlSetning) or die ("ikke mulig &aring; hente data fra databasen");
          $antallRader=mysqli_num_rows($sqlResultat); 

          if ($antallRader==0)  /* klassen er ikke registrert */
            {
              print ("Klassen finnes ikke");
            }
          else
            {	  
              $sqlSetning="DELETE FROM klasse WHERE klassekode='$klassekode';";
              mysqli_query($db,$sqlSetning) or die ("ikke mulig &aring; slette data i databasen");
                /* SQL-setning sendt til database-serveren */
		
              print ("F&oslash;lgende klasse er n&aring; slettet: $klassekode $klassenavn  <br />");
            }
        }
    }
?> 
