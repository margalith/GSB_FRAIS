    <div class="col-md-4" >
    <div class="form-group" >
         <label for="lstVisiteurs" accesskey="n">Choisir le visiteurs: </label>
                <select id="lstVisiteur" name="lstVisiteur" class="form-control">
                    <?php
                    foreach ($lesVisiteurs as $unVisiteur) {
                        $id = $unVisiteur['id'];
                        $nom = $unVisiteur['nom'];
                        $prenom = $unVisiteur['prenom'];
                            ?>
                            <option selected value="<?php echo $id ?>">
                                <?php echo $nom . ' ' . $prenom ?> </option>
                            <?php
                    }
                    ?>    

                </select>
   </div>
   <input class="btn btn btn-success"
          type="submit" value="Valider">
  </div>


    
<div class="col-md-4">
        <div class="form-group">
        <label for="lstMois" accesskey="n">Mois </label>
                <select id="lstMois" name="lstMois" class="form-control">
                    <?php
                    foreach ($lesMois as $unMois) {
                        $mois = $unMois['mois'];
                        $numAnnee = $unMois['numAnnee'];
                        $numMois = $unMois['numMois'];
                            ?>
                            <option selected value="<?php echo $mois ?>">
                                <?php echo $numAnnee . '/' . $numMois?> </option>
                            <?php
                    }
                    ?>    

                </select>
            </div>
        </form>
     </div>
    </div>   

