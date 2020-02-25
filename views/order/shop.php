<script type="text/javascript" src="assets/js/changeItemcount.js"></script>

<div class="background-black">
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
                                        <?php foreach($itemcategories as $category) : ?>
                                            <?php if(isset($selectedcategoryfilter)) : ?>
                                            <option value="<?php echo $category['category']; ?>" <?php echo(($selectedcategoryfilter === $category['category']) ? 'selected' : ''); ?>><?php echo $category['category']; ?></option>
                                            <?php else : ?>
                                                <option value="<?php echo $category['category']; ?>" ><?php echo $category['category']; ?></option>
                                            <?php endif; ?>
                                        <?php endforeach ?>
                                        <option <?php echo (empty($selectedcategoryfilter) ? 'selected' : ''); ?> value> -- bitte auswählen -- </option>
                                    </select>
                                </div>
                                <div class="col-lg-4 col-sm-12 float-left">
                                    <label for="gender" class="form-for">Geschlecht:</label>
                                    <select class="form-control" name="gender" id="gender" onchange="this.form.submit()">
                                        <?php foreach($itemgender as $gender) : ?>
                                            <?php if(isset($selectedgenderfilter)) : ?>
                                            <option value="<?php echo $gender['gender']; ?>" <?php echo(($selectedgenderfilter === $gender['gender']) ? 'selected' : ''); ?>><?php echo $gender['gender']; ?></option>
                                            <?php else : ?>
                                                <option value="<?php echo $gender['gender']; ?>" ><?php echo $gender['gender']; ?></option>
                                            <?php endif; ?>
                                        <?php endforeach ?>
                                        <option <?php echo (empty($selectedgenderfilter) ? 'selected' : ''); ?> value> -- bitte auswählen -- </option>
                                    </select>
                                </div>
                                <div class="col-lg-4 col-sm-12 float-left">
                                    <label for="color" class="form-for">Farbe:</label>
                                    <select class="form-control" name="color" id="color" onchange="this.form.submit()">
                                        <?php foreach($itemcolors as $color) : ?>
                                            <?php if(isset($selectedcolorfilter)) : ?>
                                            <option value="<?php echo $color['color']; ?>" <?php echo(($selectedcolorfilter === $color['color']) ? 'selected' : ''); ?>><?php echo $color['color']; ?></option>
                                            <?php else : ?>
                                                <option value="<?php echo $color['color']; ?>" ><?php echo $color['color']; ?></option>
                                            <?php endif; ?>
                                        <?php endforeach ?>
                                        <option <?php echo (empty($selectedcolorfilter) ? 'selected' : ''); ?> value> -- bitte auswählen -- </option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">filtern</button>
                            <?php if (empty($selectedsort["price"])) : ?>
                                <button class="btn btn-primary" type="submit" name="price" value="ASC">Preis</button>

                            <?php else : ?>
                                <input type="hidden" name="price_selected" value="<?php echo $selectedsort["price"]; ?>" />
                                <button class="btn btn-primary" type="submit" name="price" value="<?php echo $selectedsort["price"] === "ASC" ? 'DESC' : 'ASC'; ?>">Preis <?php echo $selectedsort["price"] === "ASC" ? '▾' : '▴' ?></button>
                            <?php endif; ?>
                            <?php if (empty($selectedsort["name"])) : ?>
                                <button class="btn btn-primary" type="submit" name="name" value="ASC">Name</button>

                            <?php else : ?>
                                <input type="hidden" name="name_selected" value="<?php echo $selectedsort["name"]; ?>" />
                                <button class="btn btn-primary" type="submit" name="name" value="<?php echo $selectedsort["name"] === "ASC" ? 'DESC' : 'ASC'; ?>">Name <?php echo $selectedsort["name"] === "ASC" ? '▾' : '▴'; ?></button>
                            <?php endif; ?>
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
                            <img alt="<?php echo $item['name']; ?>" src="<?php echo $item['imageurl']; ?>" />
                        </div>
                        <div class="float-left item-details">                    
                        <h4 class="item-name"><?php echo $item['name']; ?></h4>
                        <p class="item-description">
                            <?php echo $item['description']; ?>
                        </p>
                    
                        <?php 
                        if(isset($_SESSION['client_id']))
                        {
                            $itemid = $item['itemid'];
                        ?>
                        <form method="post">
                            <input type="hidden" name="itemid" value="<?php echo $itemid; ?>" />
                            <p>Preis: <?php echo $item['price']; ?> €</p>
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
                        <p>preis: <?php echo $item['price']; ?> €</p>
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
</div>
