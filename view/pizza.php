<?php
include_once "main.php";
if (!isset($pizza)) {
    header("index.php?target=pizza&action=show");
}
if (!isset($sizes)) {
    header("index.php?target=pizza&action=show");
}
if (!isset($doughs)) {
    header("index.php?target=pizza&action=show");
}
if (!isset($ingredients)) {
    header("index.php?target=pizza&action=show");
}

?>


<img src='<?= $pizza->getImg_url();?>'/><br>
<p><?php echo $pizza->getName()  ?> </p>


<form action="index.php?target=order&action=finished" method="post">
    <select>
        <?php foreach ($doughs as $dough) {?>
        <option value='<?=$dough["id"]?>'>
        <?= $dough["name"] . ((isset($dough["price"]) && $dough["price"] != 0) ? " (+" . $dough["price"] . "lv)" : ""); ?>
        </option>
        <?php } ?>
    </select>

    <select>
        <?php foreach ($sizes as $size) { ?>
        <option value='<?= $size["id"] ?>' <?php if ($pizza->getSize() == $size["id"]) { echo "selected"; } ?>>
                    <?php echo $size["name"] . ((isset($size["slices"])) ? " (" . $size["slices"] . " Slices)" : "")?>
        </option>
        <?php } ?>
    </select><br>

    <h6>Sauces</h6>
    <?php
    /** @var \model\Ingredient $sauce */
    foreach ($ingredients[0] as $sauce) {?>
        <input type="radio" name="sauces[]" value="<?= $sauce->getId() ?>"  <?php if(in_array($sauce->getName(), $pizza->getIngrNames())) { echo "checked"; } ?> > <?= $sauce->getName();?><br>
    <?php } ?>

    <h6>Spices</h6>
    <?php
    /** @var \model\Ingredient $spice */
    foreach ($ingredients[1] as $spice) {?>
        <input type="checkbox" name="spices[]" value="<?= $spice->getId() ?>"  <?php if(in_array($spice->getName(), $pizza->getIngrNames())) { echo "checked"; } ?> > <?= $spice->getName();?><br>
    <?php } ?>

    <h6>Cheeses</h6>
    <?php
    /** @var \model\Ingredient $cheese */
    foreach ($ingredients[2] as $cheese) {?>
        <input type="checkbox" name="cheeses[]" value="<?= $cheese->getId() ?>"  <?php if(in_array($cheese->getName(), $pizza->getIngrNames())) { echo "checked"; } ?> > <?= $cheese->getName();?><br>
    <?php } ?>

    <h6>Meats</h6>
    <?php
    /** @var \model\Ingredient $meat */
    foreach ($ingredients[3] as $meat) {?>
        <input type="checkbox" name="meats[]" value="<?= $meat->getId() ?>"  <?php if(in_array($meat->getName(), $pizza->getIngrNames())) { echo "checked"; } ?> > <?= $meat->getName();?><br>
    <?php } ?>

    <h6>Vegetables</h6>
    <?php
    /** @var \model\Ingredient $vegetable */
    foreach ($ingredients[4] as $vegetable) {?>
        <input type="checkbox" name="vegetables[]" value="<?= $vegetable->getId() ?>"  <?php if(in_array($vegetable->getName(), $pizza->getIngrNames())) { echo "checked"; } ?> > <?= $vegetable->getName();?><br>
    <?php } ?>

    <h6>Miscellaneous</h6>
    <?php
    /** @var \model\Ingredient $item */
    foreach ($ingredients[5] as $item) {?>
        <input type="checkbox" name="mixed[]" value="<?= $item->getId() ?>"  <?php if(in_array($item->getName(), $pizza->getIngrNames())) { echo "checked"; } ?> > <?= $item->getName();?><br>
    <?php } ?>
    <input type="submit" name="order" value="Order">
</form>
