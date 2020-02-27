<script type="text/javascript" src="assets/js/changeItemcount.js"></script>
<script type="text/javascript" src="assets/js/ajax.js"></script>

<div class="background-black">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <section>
                <h1 class="page-heading">Shop</h1>
                <?php if(isset($_GET['success'])) : ?>
                    <?php if($_GET['success'] === "1") : ?>
                        <div class="alert alert-success">
                            Der Artikel wurde erfolgreich dem Warenkorb hinzugefügt
                        </div>
                        <?php elseif($_GET['success'] === "0") : ?>        
                        <div class="alert alert-danger">
                            Es gab einen Fehler beim Hinzufügen zum Warenkorb. Bitte versuch es erneut oder kontaktiere uns!
                        </div>
                        <?php elseif($_GET['success'] === "2") : ?>        
                        <div class="alert alert-warning">
                            Bitte einen oder mehrere Artikel angeben!
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
                <div class="alert alert-success hide-js-disabled" id="ajaxsuccess">
                    Der Artikel wurde erfolgreich dem Warenkorb hinzugefügt
                </div>
                <div class="alert alert-danger hide-js-disabled" id="ajaxerror">
                    Es gab einen Fehler beim Hinzufügen zum Warenkorb. Bitte versuch es erneut oder kontaktiere uns!
                </div>
                <div class="alert alert-warning hide-js-disabled" id="ajaxwarning">
                    Bitte einen oder mehrere Artikel angeben!
                </div>
                <br/>
                <?php if(isset($_GET['t'])) : ?>
                    <?php $type = $_GET['t']; ?>
                    <?php if($type === 'merchandise') : ?>
                        <form method="post">
                            <div class="row">
                                <div class="col-lg-4 col-sm-12 float-left">
                                    <label for="category" class="form-for">Kategorie:</label>
                                    <select class="form-control" name="category" id="category" onchange="this.form.submit()">
                                        <?php foreach($itemCategories as $category) : ?>
                                            <?php if(isset($selectedCategoryFilter)) : ?>
                                            <option value="<?php echo $category['category']; ?>" <?php echo(($selectedCategoryFilter === $category['category']) ? 'selected' : ''); ?>><?php echo $category['category']; ?></option>
                                            <?php else : ?>
                                                <option value="<?php echo $category['category']; ?>" ><?php echo $category['category']; ?></option>
                                            <?php endif; ?>
                                        <?php endforeach ?>
                                        <option <?php echo (empty($selectedCategoryFilter) ? 'selected' : ''); ?> value> -- bitte auswählen -- </option>
                                    </select>
                                </div>
                                <div class="col-lg-4 col-sm-12 float-left">
                                    <label for="gender" class="form-for">Geschlecht:</label>
                                    <select class="form-control" name="gender" id="gender" onchange="this.form.submit()">
                                        <?php foreach($itemGender as $gender) : ?>
                                            <?php if(isset($selectedGenderFilter)) : ?>
                                            <option value="<?php echo $gender['gender']; ?>" <?php echo(($selectedGenderFilter === $gender['gender']) ? 'selected' : ''); ?>><?php echo $gender['gender']; ?></option>
                                            <?php else : ?>
                                                <option value="<?php echo $gender['gender']; ?>" ><?php echo $gender['gender']; ?></option>
                                            <?php endif; ?>
                                        <?php endforeach ?>
                                        <option <?php echo (empty($selectedGenderFilter) ? 'selected' : ''); ?> value> -- bitte auswählen -- </option>
                                    </select>
                                </div>
                                <div class="col-lg-4 col-sm-12 float-left">
                                    <label for="color" class="form-for">Farbe:</label>
                                    <select class="form-control" name="color" id="color" onchange="this.form.submit()">
                                        <?php foreach($itemColors as $color) : ?>
                                            <?php if(isset($selectedColorFilter)) : ?>
                                            <option value="<?php echo $color['color']; ?>" <?php echo(($selectedColorFilter === $color['color']) ? 'selected' : ''); ?>><?php echo $color['color']; ?></option>
                                            <?php else : ?>
                                                <option value="<?php echo $color['color']; ?>" ><?php echo $color['color']; ?></option>
                                            <?php endif; ?>
                                        <?php endforeach ?>
                                        <option <?php echo (empty($selectedColorFilter) ? 'selected' : ''); ?> value> -- bitte auswählen -- </option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">filtern</button>
                            <?php if (empty($selectedSort["price"])) : ?>
                                <button class="btn btn-primary" type="submit" name="price" value="ASC">Preis</button>

                            <?php else : ?>
                                <input type="hidden" name="price_selected" value="<?php echo $selectedSort["price"]; ?>" />
                                <button class="btn btn-primary" type="submit" name="price" value="<?php echo $selectedSort["price"] === "ASC" ? 'DESC' : 'ASC'; ?>">Preis <?php echo $selectedSort["price"] === "ASC" ? '▾' : '▴' ?></button>
                            <?php endif; ?>
                            <?php if (empty($selectedSort["name"])) : ?>
                                <button class="btn btn-primary" type="submit" name="name" value="ASC">Name</button>

                            <?php else : ?>
                                <input type="hidden" name="name_selected" value="<?php echo $selectedSort["name"]; ?>" />
                                <button class="btn btn-primary" type="submit" name="name" value="<?php echo $selectedSort["name"] === "ASC" ? 'DESC' : 'ASC'; ?>">Name <?php echo $selectedSort["name"] === "ASC" ? '▾' : '▴'; ?></button>
                            <?php endif; ?>
                        </form>
                    <?php endif; ?>
                <?php endif; ?>
                <?php $i = 0; ?>
                <?php if(empty($items)) : ?>        
                    <div class="alert alert-warning">
                        Zur Zeit sind keine Artikel verfügbar! Bitte kontaktiere uns oder trag dich in den Newsletter ein,
                        um zu erfahren, wenn er wieder verfügbar ist.
                    </div>
                <?php else : ?>
                    <?php foreach($items as $item) : ?>
                        <?php if($i > 0) : ?>
                            <div class="item border-top">
                        <?php else: ?>
                            <div class="item">
                        <?php endif; ?>
                                <div class="float-left item-image">
                                    <img alt="<?php echo $item['name']; ?>" src="<?php echo $item['imageurl']; ?>" />
                                </div>
                                <div class="float-left item-details">                    
                                    <h4 class="item-name"><?php echo $item['name']; ?></h4>
                                    <p class="item-description">
                                        <?php echo $item['description']; ?>
                                    </p>
                                
                                    <?php if(isset($_SESSION['client_id'])) : ?>
                                        <?php $itemid = $item['itemid']; ?>
                                        <form method="post">
                                            <input type="hidden" name="itemid" value="<?php echo $itemid; ?>" />
                                            <p>Preis: <?php echo $item['price']; ?> €</p>
                                            <p>Anzahl: 
                                            <button type="button" class="btn-fixed btn-primary hide-js-disabled" onclick="changeItemcount('itemcount<?php echo $itemid; ?>', '-')">-</button>
                                            <input type="text" id="itemcount<?php echo $itemid; ?>" class="input-inline input-itemcount" name="itemcount" value="1">
                                            <button type="button" class="btn-fixed btn-primary hide-js-disabled" onclick="changeItemcount('itemcount<?php echo $itemid; ?>', '+')">+</button>
                                            </p><br>
                                            <noscript>
                                                <button type="submit" class="btn btn-primary hide-js-enabled" name="addItemToCart">In den Warenkorb</button>
                                            </noscript>
                                            <a class="btn btn-primary hide-js-disabled" name="addItemToCart" onclick="postCartWithAjax(<?php echo $itemid; ?>, 'itemcount<?php echo $itemid; ?>')">In den Warenkorb</a>
                                        </form>
                                    <?php else : ?>
                                        <p>preis: <?php echo $item['price']; ?> €</p>
                                        <button class="btn btn-disabled" disabled>in den Warenkorb</button><br>Bitte einloggen!
                                    <?php endif; ?>
                                    <?php $i++; ?>
                                </div>
                            </div>
                    <?php endforeach; ?>                
                <?php endif; ?>
            </section>
        </div>
    </div>
</div>