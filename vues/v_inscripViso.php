<?php 
include('vues/v_sommaire.php');
?>

<form method="post" action="index.php?uc=inscription&action=valideVisio">
<?php 

foreach($lesViso as $visio) { ?>
    <div style="background-color: white;">
        <h1><?php echo $visio['nomVisio']?></h1>    
        <h4 style="color: blue;">Le <?php echo $visio['dateVisio']?></h4>
        <p><strong>Objectif : <?php echo $visio['objectif']?></strong></p>
        <input style="margin-left: 2%;" type="checkbox" name="inscription[]" value="<?php echo $visio['id']?>">
        <label for="inscription">S'inscrire</label>

    </div>


<?php } ?> 
    <button class="btn btn-primary signup" style="margin-left: 38%; margin-top: 1%;" type="submit">Confirmer l'inscription au visioconference</button>
</form>