<?php
include_once "main.php";
if (!isset($pizza)) {
    header("index.php?target=pizza&action=showAll");
}
if (!isset($sizes)) {
    header("index.php?target=pizza&action=showAll");
}
if (!isset($doughs)) {
    header("index.php?target=pizza&action=showAll");
}
if (!isset($ingredients)) {
    header("index.php?target=pizza&action=showAll");
}

?>

<img src='<?= $pizza->getImg_url();?>'/><br>
<p><?php echo $pizza->getName()  ?> </p>

<form action="index.php?target=order&action=finish" method="post">
    <input type="hidden" value="<?=$pizza->getId();?>" name="pizza_id">
    <select name="dough">
        <?php
        /** @var model\Dough $dough */
        foreach ($doughs as $dough) {?>
        <option value='<?=$dough->getId()?>'>
        <?= $dough->getName() . (($dough->getPrice() && $dough->getPrice() != 0) ? " (+" . $dough->getPrice() . "lv)" : ""); ?>
        </option>
        <?php } ?>
    </select>

    <select name="size">
        <?php
        /** @var model\Size $size */
        foreach ($sizes as $size) { ?>
        <option value='<?= $size->getId() ?>' <?php if ($pizza->getSize() == $size->getId()) { echo "selected"; } ?>>
                    <?php echo $size->getName() . ($size->getSlices() ? " (" . $size->getSlices() . " Slices)" : "")?>
        </option>
        <?php } ?>
    </select><br>
    <h6>Quantity</h6>
    <input type="number" min="1" max="100" name="quantity" value="1" required>


    <h6>Toppings:</h6>
    <p><?php echo $pizza->printIngredients(); ?></p>

    <h6>Sauces</h6>
    <?php
    /** @var \model\Ingredient $sauce */
    foreach ($ingredients[0] as $sauce) {?>
        <input type="radio" name="sauces[]" value="<?= $sauce->getId() ?>"
            <?php if(in_array($sauce->getName(), $pizza->getIngrNames()) )
            { echo "checked "; } ?>
        > <?= $sauce->getName();?><br>
    <?php } ?>

    <h6>Herbs</h6>
    <?php
    /** @var \model\Ingredient $spice */
    foreach ($ingredients[1] as $herb) {?>
        <input type="checkbox" name="herbs[]" value="<?= $herb->getId() ?>"
            <?php if(in_array($herb->getName(), $pizza->getIngrNames())) { echo "checked"; } ?>
        > <?= $herb->getName();?><br>
    <?php } ?>

    <h6>Cheeses</h6>
    <?php
    /** @var \model\Ingredient $cheese */
    foreach ($ingredients[2] as $cheese) {?>
        <input type="checkbox" name="cheeses[]" value="<?= $cheese->getId() ?>"
            <?php if(in_array($cheese->getName(), $pizza->getIngrNames())) { echo "checked"; } ?>
        > <?= $cheese->getName();?><br>
    <?php } ?>

    <h6>Meats</h6>
    <?php
    /** @var \model\Ingredient $meat */
    foreach ($ingredients[3] as $meat) {?>
        <input type="checkbox" name="meats[]" value="<?= $meat->getId() ?>"
            <?php if(in_array($meat->getName(), $pizza->getIngrNames())) { echo "checked"; } ?>
        > <?= $meat->getName();?><br>
    <?php } ?>

    <h6>Vegetables</h6>
    <?php
    /** @var \model\Ingredient $vegetable */
    foreach ($ingredients[4] as $vegetable) {?>
        <input type="checkbox" name="vegetables[]" value="<?= $vegetable->getId() ?>"
            <?php if(in_array($vegetable->getName(), $pizza->getIngrNames())) { echo "checked"; } ?>
        > <?= $vegetable->getName();?><br>
    <?php } ?>

    <h6>Miscellaneous</h6>
    <?php
    /** @var \model\Ingredient $item */
    foreach ($ingredients[5] as $item) { 
        if($pizza->getName() != "Master Burger Pizza" && $item->getName() == "Burger Sauce") continue; ?>
        <input type="checkbox" name="mixed[]" value="<?= $item->getId() ?>"
            <?php if(in_array($item->getName(), $pizza->getIngrNames())) { echo "checked"; }
           ?>
        > <?= $item->getName();?><br>
    <?php } ?>

    <input type="submit" name="order" value="Order">
</form>
