<script type="text/javascript" src="assets/js/changeItemcount.js"></script>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <section>
            <h1>Shop</h1>
            <?php
            if(isset($_GET['success']))
            {
                if($_GET['success'] === "1")
                {
                    ?>        
                    <div class="alert alert-success">
                        Der Gegenstand wurde erfolgreich dem Warenkorb hinzugefügt
                    </div>
                    <?php
                }
                else if($_GET['success'] === "0")
                {
                    ?>        
                    <div class="alert alert-danger">
                        Es gab einen Fehler beim Hinzufügen zum Warenkorb. Bitte kontaktiere uns!
                    </div>
                    <?php
                }
                else if($_GET['success'] === "2")
                {
                    ?>        
                    <div class="alert alert-danger">
                        Bitte ein oder mehr Gegenstände angeben!
                    </div>
                    <?php
                }
            }
            ?>
            <br/>
            <?php
            $i = 0;
            if(empty($items))
            {
                ?>        
                <div class="alert alert-warning">
                    Der gewählte Gegenstand ist nicht mehr verfügbar! Bitte kontaktiere uns oder trag dich in den Newsletter ein,
                    um zu erfahren, wenn er wieder verfügbar ist.
                </div>
                <?php
            }
            else
            {
                foreach($items as $item) 
                {
                    if($_GET['t'] === $item['CATEGORY'])
                    {
                        if($i > 0)
                        {
                            ?>
                            <div class="item border-top">
                            <?php
                        }
                        else
                        {
                            ?>
                            <div class="item">
                            <?php
                        }
                        ?>
                        <div class="float-left item-image">
                            <img class="" src="<?php echo $item['IMAGEURL']; ?>" />
                        </div>
                        <div class="float-left item-details">                    
                        <h4 class="item-name"><?php echo $item['NAME']; ?></h4>
                        <p class="item-description">
                            <?php echo $item['DESCRIPTION']; ?>
                        </p>
                    
                        <?php 
                        if(isset($_SESSION['client_id']))
                        {
                            $itemid = $item['ITEMID'];
                            $itemcategory = $item['CATEGORY'];
                            $itemfiltercategory = $item['FILTERCATEGORY'];
                        ?>
                        <form method="post">
                            <input type="hidden" name="itemid" value="<?php echo $itemid; ?>" />
                            <input type="hidden" name="itemcategory" value="<?php echo $itemcategory; ?>" />
                            <input type="hidden" name="itemfiltercategory" value="<?php echo $itemfiltercategory; ?>" />
                            <p>Preis: <?php echo $item['PRICE']; ?> €</p>
                            <p>Anzahl: 
                            <button type="button" class="btn-fixed btn-primary no-script" onclick="changeItemcount('itemcount<?php echo $itemid; ?>', '-')">-</button>
                            <input type="text" id="itemcount<?php echo $itemid; ?>" class="input-inline input-itemcount" name="itemcount" value="1">
                            <button type="button" class="btn-fixed btn-primary no-script" onclick="changeItemcount('itemcount<?php echo $itemid; ?>', '+')">+</button>
                            </p><br>
                            <button type="submit" class="btn btn-primary" name="additemtocart">In den Warenkorb</button>
                        </form>
                        <?php
                        }
                        else
                        {
                        ?>
                        <p>Preis: <?php echo $item['PRICE']; ?> €</p>
                        <button class="btn btn-disabled" disabled>in den Warenkorb</button> Bitte einloggen!
                        <?php
                        }
                    
                        $i++;
                        ?>
                        </div>
                        </div>
                    <?php 
                    }
                }
            }
            ?>
        </section>
    </div>
</div>