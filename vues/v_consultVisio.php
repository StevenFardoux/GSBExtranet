<?php
include('vues/v_sommaire.php');
?>

<div>
    <?php if ($droit == DROIT_MEDECIN) {
        foreach ($lesViso as $visio) { ?>
            <div style="background-color: white; padding-left: 1%;">
                <h1><?php echo $visio['nomVisio'] ?></h1>
                <h4 style="color: blue;">Le <?php echo $visio['dateVisio'] ?></h4>
                <p><strong>Objectif :</strong> <?php echo $visio['objectif'] ?></p>
                <a style="font-size: 20px;" href="<?php echo $visio['url'] ?>">Cliquez ici pour rejoindre la visioconference</a>
                
                    <h2>Avis :</h2>
                    <?php
                    if (!(empty($lesAvis[$visio['id']]))) {
                        foreach ($lesAvis[$visio['id']] as $avis) {
                            if ($avis['valider'] == false) {
                            } else { ?>
                                <h5><?php echo $avis['description'] ?></h5>
                                <br>
                        <?php }
                        }
                    } else { ?>
                        <h4>Aucun avis n'a encore été publier !</h4>
                    <?php } 
                    if (date("Y-m-d") >= $visio['dateVisio']) { ?>
                    <form method="post" action="index.php?uc=avis&action=ajouter">
                        <textarea name="avis" rows="3" cols="40" placeholder="Ajouter un avis"></textarea>
                        <input name="id" value="<?php echo $visio['id'] ?>" hidden />
                        <input type="submit" class="btn btn-primary signup" value="Soumettre" style="margin-bottom: 3%;" />
                    </form>
                <?php } ?>

            </div>
            <?php }
    } else if ($droit == DROIT_MODERATEUR) {
        foreach ($lesAvis as $avis) {
            // var_dump($avis);
            if (!($avis['valider'])) { ?>

                <div style="background-color: white; padding-left: 1%;">
                    <h4 style="padding: 1%;"><?php echo $avis['description']; ?></h4>
                    <div class="row">
                        <form class="col-sm-1" method="post" action="index.php?uc=avis&action=accepter">
                            <input name="id" value="<?php echo $avis['idAvis'] ?>" hidden />
                            <input type="submit" class="btn btn-primary signup" value="accepter">
                        </form>

                        <form class="col-sm-1" method="post" action="index.php?uc=avis&action=refuser">
                            <input name="id" value="<?php echo $avis['idAvis'] ?>" hidden />
                            <input type="submit" class="btn signup" value="refuser">
                        </form>
                    </div>
                </div>
        <?php }
        }
        ?>
    <?php } else if ($droit == DROIT_CHEFPROD) { ?>
        <div class="row">
            <form class="text-center" method="POST" action="index.php?uc=visio&action=default">
                <input class="btn btn-primary" type="submit" name="ajouter" value="Ajouter une visioconférence">
            </form>
        </div>


        <?php foreach ($lesVisio as $visio) { ?>
            <div style='background-color: white; padding-left: 1%; padding: 1%; margin-bottom: 1%;'>
                <h4><?php echo $visio['nomVisio'] ?></h4>
                <p><strong>objectif :</strong><?php echo $visio['objectif'] ?></p>
                <a href="?=<?php $visio['url'] ?>">lien vers la visioconférence</a>
                <h5 style="color: blue;">Le <?php echo $visio['dateVisio'] ?></h5>

                <form method="POST" action="index.php?uc=visio&action=default">
                    <input name="id" value="<?php echo $visio['id'] ?>" hidden />

                    <input class="btn" type="submit" name="modifier" value="Modifier">
                    <input class="btn" type="submit" name="supprimer" value="Supprimer">
                </form>
            </div>
    <?php }
    } 
?>
</div>