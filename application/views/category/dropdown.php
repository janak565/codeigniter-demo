<?php if(isset($category) && !empty($category)){?>
<select>
<?php foreach($category as $cl) { ?>
  <option value="<?php echo $cl["id"] ?>"><?php echo $cl["name"]; ?></option>
<?php } ?>
</select>
<?php }?>
<ul>
<?php
if(isset($tree_category) && !empty($tree_category)){
  //$res = fetchCategoryTreeList();
  foreach ($tree_category as $r) {
    echo  $r;
  }
}	
?>
</ul>