<?php
include('vues/v_sommaire.php');
?>

<link rel="stylesheet" href="css/produits.css">
<div class="produits-list">
    <?php
    if ($droit == DROIT_CHEFPROD) { ?>

    <div class="row">
        <form class="text-center" method="POST" action="index.php?uc=prod&action=default">
            <input class="btn btn-primary" type="submit" name="ajouter" value="Ajouter un Produits">
        </form>
    </div>
    <?php
        foreach ($lesProds as $produit) :

    ?>
            <div class="produit">
                <h1><?= $produit->nom ?></h1>
                <div class="separator"></div>
                <div class="produit-content">
                    <div class="produit-body">
                        <div>
                            <h4>Informations:</h4>
                            <p><?= $produit->information ?></p>
                        </div>
                        <div>
                            <h4>Objectif:</h4>
                            <p><?= $produit->objectif ?></p>
                        </div>

                        <div>
                            <h4>Effets indésirables:</h4>
                            <p><?= $produit->effetIndesirable ?></p>
                        </div>
                    </div>
                    <img class="produit-image" src="images/produits/<?= $produit->image ?>" alt="<?= $produit->nom ?>">
                </div>
                <form method="POST" action="index.php?uc=prod&action=default">
                <input name="id" value="<?php echo $produit->id ?>" hidden />
                    <input class="btn" type="submit" name="modifier" value="Modifier">
                    <input class="btn" type="submit" name="supprimer" value="Supprimer">
                </form>
                

            </div>

        <?php endforeach;
    } else { ?>
        <?php

        $lesProduits = $pdo->getProduits();
        foreach ($lesProduits as $produit) :
        ?>

            <div class="produit">
                <h1><?= $produit->nom ?></h1>
                <div class="separator"></div>
                <div class="produit-content">
                    <div class="produit-body">
                        <div>
                            <h4>Informations:</h4>
                            <p><?= $produit->information ?></p>
                        </div>
                        <div>
                            <h4>Objectif:</h4>
                            <p><?= $produit->objectif ?></p>
                        </div>

                        <div>
                            <h4>Effets indésirables:</h4>
                            <p><?= $produit->effetIndesirable ?></p>
                        </div>
                    </div>
                    <img class="produit-image" src="images/produits/<?= $produit->image ?>" alt="<?= $produit->nom ?>">
                </div>

            </div>

    <?php endforeach;
    } ?>
</div>