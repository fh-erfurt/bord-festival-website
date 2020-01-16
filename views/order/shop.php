<script type="text/javascript" src="assets/js/changeItemcount.js"></script>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <section>
            <h1 class="page-heading">Shop</h1>
            <?php
            if(isset($_GET['success']))
            {
                if($_GET['success'] === "1")
                {
                    ?>        
                    <div class="alert alert-success">
                        Der Artikel wurde erfolgreich dem Warenkorb hinzugefügt
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
                        Bitte einen oder mehrere Artikel angeben!
                    </div>
                    <?php
                }
            }
            ?>
            <br/>
            <?php if(isset($_GET['t'])) : ?>
                <?php $type = $_GET['t']; ?>
                <?php if($type === 'merchandise') : ?>
                    <form method="post">
                        <div class="row">
                            <div class="col-lg-4 col-sm-12 float-left">
                                <label for="category" class="form-for">Kategorie:</label>
                                <select class="form-control" name="category" id="category" onchange="this.form.submit()">
                                    <?php $filterselected = false; ?>
                                    <?php foreach($itemcategories as $category) : ?>
                                        <?php $select = false; ?>
                                        <?php foreach($selection as $filter) : ?>
                                            <?php if($category['category'] === $filter['category']) : ?>
                                                <?php $filterselected = true; ?>
                                                <?php $select = true; ?>
                                            <?php endif ?>
                                        <?php endforeach ?>
                                        <option value="<?php echo $category['category']; ?>" <?php echo($select ? 'selected' : ''); ?>><?php echo $category['category']; ?></option>
                                    <?php endforeach ?>
                                    <option <?php echo $filterselected ? '' : 'selected'; ?> value> -- bitte auswählen -- </option>
                                </select>
                            </div>
                            <div class="col-lg-4 col-sm-12 float-left">
                                <label for="gender" class="form-for">Geschlecht:</label>
                                <select class="form-control" name="gender" id="gender" onchange="this.form.submit()">
                                    <?php $filterselected = false; ?>
                                    <?php foreach($itemgender as $gender) : ?>
                                        <?php $select = false; ?>
                                        <?php foreach($selection as $filter) : ?>
                                            <?php if($gender['gender'] === $filter['gender']) : ?>
                                                <?php $filterselected = true; ?>
                                                <?php $select = true; ?>
                                            <?php endif; ?>
                                        <?php endforeach ?>
                                        <option value="<?php echo $gender['gender']; ?>" <?php echo($select ? 'selected' : ''); ?>><?php echo $gender['gender']; ?></option>
                                    <?php endforeach ?>
                                    <option <?php echo $filterselected ? '' : 'selected'; ?> value> -- bitte auswählen -- </option>
                                </select>
                            </div>
                            <div class="col-lg-4 col-sm-12 float-left">
                                <label for="color" class="form-for">Farbe:</label>
                                <select class="form-control" name="color" id="color" onchange="this.form.submit()">
                                    <?php $filterselected = false; ?>
                                    <?php foreach($itemcolors as $color) : ?>
                                        <?php $select = false; ?>
                                        <?php foreach($selection as $filter) : ?>
                                            <?php if($color['color'] === $filter['color']) : ?>
                                                <?php $filterselected = true; ?>
                                                <?php $select = true; ?>
                                            <?php endif ?>
                                        <?php endforeach ?>
                                        <option value="<?php echo $color['color']; ?>" <?php echo($select ? 'selected' : ''); ?>><?php echo $color['color']; ?></option>
                                    <?php endforeach ?>
                                    <option <?php echo $filterselected ? '' : 'selected'; ?> value> -- bitte auswählen -- </option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">filtern</button>
                    </form>
                <?php endif; ?>
            <?php endif; ?>
            <?php
            $i = 0;
            if(empty($items))
            {
                ?>        
                <div class="alert alert-warning">
                    Zur Zeit sind keine Artikel verfügbar! Bitte kontaktiere uns oder trag dich in den Newsletter ein,
                    um zu erfahren, wenn er wieder verfügbar ist.
                </div>
                <?php
            }
            else
            {
                foreach($items as $item) 
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
                    ?>
                    <form method="post">
                        <input type="hidden" name="itemid" value="<?php echo $itemid; ?>" />
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
            ?>
        </section>
    </div>
</div>
