<?php
include('vues/v_sommaire.php');
?>


<div class="page-content container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-wrapper">
                    <div class="box">

                        <div class="content-wrap">
                            <form method="post" action="index.php?uc=visio&action=modif">
                                <input name="nom" class="form-control" type="text" value=" <?php echo $laVisio['nomVisio'] ?>" required/>
                                <textarea name="objectif" class="form-control" type="text" required style="margin-bottom: 3%;"><?php echo $laVisio['objectif'] ?></textarea>
                                <input name="url" class="form-control" type="text" value="<?php echo $laVisio['url'] ?>" required/>
                                <input name="date" class="form-control" type="date" value="<?php echo $laVisio['dateVisio'] ?>" required/>
                                <br>
                                <input type="submit" class="btn btn-primary signup" value="Modifier" />
                            </form>
                            </br>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>