<?php
include('vues/v_sommaire.php');
?>

<div class="page-content container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-wrapper">
                    <div class="box">

                        <div class="content-wrap">
                            <form method="post" action="index.php?uc=visio&action=add">
                                <input name="nom" class="form-control" type="text" placeholder="Nom" required/>
                                <textarea name="objectif" class="form-control" type="text" placeholder="objectif" required style="margin-bottom: 3%;"></textarea>
                                <input name="url" class="form-control" type="text" placeholder="url" required/>
                                <input name="date" class="form-control" type="date" placeholder="date" required/>
                                <br>
                                <input type="submit" class="btn btn-primary signup" value="Ajouter" />
                            </form>
                            </br>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>