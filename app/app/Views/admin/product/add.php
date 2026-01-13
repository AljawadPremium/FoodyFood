<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style type="text/css">
    .hsm_price,.hss_price{
        display: none;
    }
    .form-control {
        margin-bottom: 20px;
    }
    .showImage {
        display: none;
    }
</style>
<?php if (!empty($edit)): ?>
    <style type="text/css">.showImage{display: inline-block;}</style>
<?php endif ?>
<?php
$label = 'Add';
$special_menu = '0';
$product_name = $product_name_ar = $product_name_ku = $sku =   $description = $price = $tax = $status_deactive = $sale_price = $editcategory = $edit_shop = $tags = $short_description =  $transaction_cost = $stock_deactive = $stock = $shipping_cost = $product_image = $image_gallery   = $price_select = $t_id = $product_image_url = '';

$short_description_ar = $description_ar = '';
if (!empty($edit))
{
    $t_id = en_de_crypt($edit->id);
    $sku = $edit->sku;
    $short_description = $edit->short_description;
    $short_description_ar = $edit->short_description_ar;
    $description_ar = $edit->description_ar;
    $product_name = $edit->product_name;
    $product_name_ar = $edit->product_name_ar;
    $product_name_ku = $edit->product_name_ku;
    $price = $edit->price;
    $tax = $edit->tax;
    $description = $edit->description;
    $product_image = $edit->product_image;
    $product_image_url = base_url('public/admin/products/').$product_image;
    $image_gallery = $edit->image_gallery;
    $sale_price = $edit->sale_price;
    // $shipping_cost = $edit->shipping_cost;
    $editcategory = $edit->category;
    $edit_shop = $edit->shop_id;
    $stock = $edit->stock;
    $tags = $edit->tags;
    $price_select = $edit->price_select;
    $gallery_images = $edit->image_gallery;
    $special_menu = $edit->special_menu;
    if($price_select==1)
    {
        $selected_singhle="selected";
        $selected_multi="";
        echo "<style> .hss_price{ display:block; } </style>";
    }elseif($price_select==2)
    {
        $selected_singhle="";
        $selected_multi="selected";
        echo "<style> .hsm_price{ display:block; } </style>";
    }
    $price_select_dis='disabled';
    $stock_active = $edit->stock_status == 'instock' ? 'checked' : '';
    $disabled = $edit->stock_status == 'instock' ? '' : 'disabled';
    $stock_deactive = $edit->stock_status == 'notinstock' ? 'checked' : '';
    $status_active = $edit->status == '1' ? 'checked' : '';
    $status_deactive = $edit->status == '0' ? 'checked' : '';
    $label = 'Update';
}
else
{
    $status_active = 'checked';
    $stock_active = 'checked';
    $selected_singhle="";
    $selected_multi="";
    $price_select_dis='';
    $sled_cus_list=array();
}
if(empty($stock_deactive) && empty($stock_active)) $stock_deactive = 'checked';
?>
<div class="vertical-overlay"></div>
<div class="main-content">
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Product</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="<?php echo base_url('admin') ?>">Dashboards</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo base_url('admin/banner') ?>">Listing</a></li>
                            <li class="breadcrumb-item active"><?php echo $label; ?></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <input type="hidden" class="product_id" value="<?php echo $t_id ?>">
                    <form class="product_add_edit">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label>Product Name</label>
                                        <input type="text" name="product_name" class="product_name form-control" value="<?php echo $product_name; ?>" placeholder="Product Name">
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Product Name (Ar)</label>
                                        <input type="text" name="product_name_ar" class="product_name form-control" value="<?php echo $product_name_ar; ?>" placeholder="Product Name">
                                    </div>
                                    <div class="col-sm-3" >
                                        <label>Sku</label>
                                        <input type="text" name="sku" class="sku form-control" value="<?php echo $sku; ?>" placeholder="Enter tags to search">
                                    </div>
                                    
                                    <div class="col-sm-3" style="display: none;">
                                        <label>Shop</label>
                                        <select name="shop_id" class="get_shop" required>
                                            <option value="0">Select Shop</option>
                                            <?php
                                                if (!empty($shop_listing)) {
                                                    foreach ($shop_listing as $ckey => $cvalue) {
                                                        $shop = ($edit_shop == $cvalue['id'] ) ? "selected" : "";
                                                        ?>
                                            <option value="<?php echo $cvalue['id']; ?>" <?php echo $shop; ?>  ><?php echo $cvalue['display_name']; ?></option>
                                            <?php } } ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Category</label>
                                        <select id="main_category" name="category" class="get_sub_category" required>
                                            <?php
                                                if(!isset($edit)){ ?>
                                            <option value="0">Select Category</option>
                                            <?php }   ?>
                                            <?php
                                                if (!empty($category))
                                                {
                                                    foreach ($category as $ckey => $cvalue)
                                                    {
                                                        $category = ($editcategory == $cvalue['id'] ) ? "selected" : "";
                                                        ?>
                                            <option value="<?php echo $cvalue['id']; ?>" <?php echo $category; ?>  ><?php echo $cvalue['display_name']; ?></option>
                                            <?php
                                                }
                                                } ?>
                                        </select>
                                    </div>
                                    <div class="clear"></div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="groups">Stock Status</label>
                                            <div>
                                                <input type="radio" value="instock" id="instock" name="stock_status" <?php echo $stock_active; ?>> In stock
                                                <input type="radio" value="notinstock" id="notinstock" name="stock_status" <?php echo $stock_deactive; ?>> Out of stock
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Quantity in Stock</label>
                                        <input type="number" id="stock" name="stock" class="form-control" value="<?php echo $stock; ?>" placeholder="Enter available Qty">
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Please enter short description</label>
                                        <input type="text" name="short_description" class="short_description form-control" value="<?php echo $short_description; ?>" placeholder="Enter short description">
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Please enter short description (Ar)</label>
                                        <input type="text" name="short_description_ar" class="short_description form-control" value="<?php echo $short_description_ar; ?>" placeholder="Enter short description">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="clear"></div>
                                    <div class="col-sm-6">
                                        <label>Description</label>
                                        <textarea id="ckeditor10" name="description" placeholder="Enter description"><?php echo $description; ?></textarea>
                                        <br>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Description (Ar)</label>
                                        <textarea id="ckeditor10_ar" name="description_ar" placeholder="Enter description"><?php echo $description_ar; ?></textarea>
                                        <br>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="groups">Status</label>
                                            <div>
                                                <input type="radio" value="1" name="status" <?php echo $status_active; ?>> Active
                                                <input type="radio" value="0" name="status" <?php echo $status_deactive; ?>> Deactive
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3" style="display: none;">
                                        <label>Special Dish Product</label>
                                        <select class="form-control" name="special_menu" >
                                            <option value="">Select</option>
                                            <option value="1" <?php if($special_menu==='1') echo 'selected="selected"';?>>Yes</option>
                                            <option value="0" <?php if($special_menu==='0') echo 'selected="selected"';?>>No</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3" style="display: none;">
                                        <label>Tax Percentage ( % )</label>
                                        <input  placeholder="Enter tax percentage" type="number" name="tax" class="form-control" value="<?php echo $tax; ?>">
                                    </div>
                                    <div class="col-sm-3" style="">
                                        <label for="Price">Select Price</label>
                                        <select  placeholder="" id="price_select" name="price_select" <?php echo $price_select_dis; ?> >
                                            <option value="0">Select Price</option>
                                            <option value="1" <?php echo $selected_singhle; ?>>Single Size</option>
                                            <!-- <option value="2" <?php echo $selected_multi; ?>>Multi Size</option> -->
                                        </select>
                                    </div>
                                    <!-- <div class="clear"></div> -->
                                    <div class="col-sm-3 hss_price">
                                        <label>Our Price</label>
                                        <input type="text" name="sale_price" class="decimal form-control" value="<?php echo $sale_price; ?>">
                                    </div>
                                    <div class="col-sm-3 hss_price" style="">
                                        <label>Market Price</label>
                                        <input type="text" name="price" class="decimal form-control" value="<?php echo $price; ?>">
                                    </div>
                                    <div class="col-sm-12 hsm_price" >
                                        <label style=""> Select attribute (if applicable)</label>
                                        <div class="row" style="">
                                            <?php
                                                if (isset($attribute))
                                                {
                                                    foreach ($attribute as $akey => $avalue)
                                                    {
                                                        echo '<div class="col-sm-6 '.$avalue['name'].' ">
                                                        <div class="form-group demo-tagsinput-area">
                                                        <div class="form-line">
                                                        <h6>Select '.$avalue['name'].'</h6>
                                                        <select multiple placeholder="'.$avalue['name'].'" name="attribute[]" class="pr_attribute" id="select_size'.$avalue['id'].'"  >';
                                                        foreach ($avalue['item'] as $itkey => $itvalue)
                                                        {
                                                            if (!empty($product_attribute))
                                                            {
                                                                echo '<option data-id="'.$itvalue['item_name'].'" value="'.$itvalue['id'].','.$itvalue['item_name'].'" '.(in_array($itvalue['id'], $product_attribute)? 'selected':'').' >'.$itvalue['item_name'].'</option>';
                                                            }
                                                            else
                                                            {
                                                                echo '<option data-id="'.$itvalue['item_name'].'" value="'.$itvalue['id'].','.$itvalue['item_name'].'" >'.$itvalue['item_name'].'</option>';
                                                            }
                                                        }
                                                        echo '</select>
                                                        </div>
                                                        </div>
                                                        </div>';
                                                    }
                                                }
                                                
                                                ?>
                                            <?php
                                                if (isset($edit)) {
                                                    $product_attribute2=implode(",",$product_attribute);
                                                    ?>
                                            <input type='hidden' id="attribute2" name="attribute2" value="<?php echo $product_attribute2 ?>">
                                            <?php } else { ?>
                                            <input type='hidden' id="attribute2" name="attribute2">
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="margin-bottom: 15px" id="sub_cat_listing">
                                        <?php
                                            if (isset($edit)) {
                                                if(!empty($p_attr)){
                                                    foreach ($p_attr as $key => $p_attr2) {
                                                        $size_id[]=$p_attr2['item_id']; ?>
                                        <div class="shattbute" id="<?php echo $p_attr2['item_id']; ?>">
                                            <label class="item_nameee"><?php echo $p_attr2['item_name']; ?></label>
                                            <label class="attribute_p">Our Price<input type="text" class="form-control" name="attribute_sale_price[]" value="<?php echo $p_attr2['sale_price']; ?>" required></label>
                                            <label class="attribute_p">Market  Price<input type="text"  name="attribute_price[]" class="form-control" value="<?php echo $p_attr2['price']; ?>" required></label>
                                        </div>
                                        <?php } } } ?>
                                    </div>
                                    <div class="col-sm-12" style="display: none;">
                                        <label>Add Extra</label>
                                        <div class="row">
                                            <div class="extra_records">
                                                <input class="form_as" name="extra_name[]" type="text" placeholder="Add extra (No Tomato / No Onion)">
                                                <input class="decimal form_as" name="extra_price[]" placeholder="Add Extra Price" type="text" value="">
                                                <a class="add_btn_extra" href="javascript:void(0);">Add More</a>
                                            </div>
                                            <div class="extra_added">
                                                <?php if (!empty($extra)): ?>
                                                <?php foreach ($extra as $keey => $vealue): ?>
                                                <div class="remove">
                                                    <input type="hidden" name="extra_id_added[]" value="<?php echo $vealue['id']; ?>">
                                                    <input class="form_as" name="extra_name_added[]" type="text" placeholder="Add extra (No Tomato / No Onion)" value="<?php echo $vealue['name']; ?>">
                                                    <input class="decimal form_as" name="extra_price_added[]" placeholder="Add Extra Price" type="text" value="<?php echo $vealue['price']; ?>">
                                                    <a class="remove_added_extra" href="javascript:void(0);">remove</a>
                                                </div>
                                                <?php endforeach ?>
                                                <?php endif ?>
                                            </div>
                                            <div class="add_extra_for_product"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <br>
                                        <label>Upload Product Gallery Images</label>
                                        <input type="file" class="form-control image_check" data-class="blah" name="image" multiple="" accept="image/*">
                                        <div class="row" >
                                            <ul id="sortable" class="main_wrap_multpl_cls prepend_img"></ul>
                                            <?php
                                                $index = 1;
                                                if (!empty($gallery_images)) {
                                                    $g_image = explode(',', $gallery_images);
                                                    foreach ($g_image as $key => $value) { ?>
                                            <div class="col-md-2 pica_<?php echo $key ?>">
                                                <div class="site-upload-img ">
                                                    <div id="pica_<?php echo $key ?>" data-name="<?php echo $value ?>" class="multipl_car_div">
                                                        <input type="hidden" name="gallery_images[]" value="<?php echo $value ?>">
                                                        <img src="<?php echo base_url('public/admin/products/') ?><?php echo $value ?>" class="img_multpl_img" >
                                                        <div class="clear" ></div>
                                                        <ul style="font-size: 18px;">
                                                            <li>
                                                                <div class="zoom_multpl_img" data-name="<?php echo $value ?>" data-toggle="modal" data-target="#zoom_img_as" >
                                                                    <i class="fa fa-search-plus" aria-hidden="true"></i>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="delet_multpl_img"><i class="fa fa-trash" aria-hidden="true" onclick="remove_pic('a_<?php echo $key ?>',',<?php echo $value ?>')"></i> </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php $index++; } } ?>
                                            <div class="galryim_pop"></div>
                                        </div>
                                        <div class="col-sm-4">
                                            <br>
                                            <label>Product image</label>
                                            <input type="file" class="ban_img form-control" name="product_image" accept="image/*">
                                            <div class="showImage" style="background-image: url(<?php echo $product_image_url; ?>) "></div>
                                        </div>
                                        <div class="col-sm-12">
                                            <span class="error_show"></span>
                                            <input class="btn btn-primary" type="submit" value="<?php echo $label; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<link href='<?php echo base_url(); ?>/public/admin/css/chosen.css' rel='stylesheet' media='screen'>
<script src='<?php echo base_url(); ?>/public/admin/js/chosen.jquery.js'></script>
<script type="text/javascript">
var Price_flag;
var yourArray=[];
<?php if (isset($edit)) {
foreach ($product_attribute as $key => $value2) { ?>
value2=<?php echo $value2; ?>;
value2=value2.toString();
yourArray.push(value2);
<?php }?>
<?php } ?>
$(document).on('change','#select_size20',function(event,params)
{
<?php if(!isset($edit)) { ?>
var val=$(this).val();
var deselected_val =params.deselected;
var selected_val =params.selected;
if (typeof(deselected_val) != "undefined")
{
var deselected_val = deselected_val.split(",");
var size_id=deselected_val[0];
var size_name=deselected_val[1];
if ($.inArray(size_id, yourArray) != -1)
{
for( var i = 0; i < yourArray.length; i++){
if ( yourArray[i] === size_id) {
yourArray.splice(i, 1);
}
}
$("#attribute2").val(yourArray);
}
$("#"+size_id).remove();
}
if (typeof(selected_val) != "undefined")
{
var selected_val = selected_val.split(",");
var size_id=selected_val[0];
var size_name=selected_val[1];
yourArray.push(size_id);
$("#attribute2").val(yourArray);
var opt='<div class="shattbute" id="'+size_id+'"><label class="attribute_p">'+size_name+'</label>   <label>Our Price<input type="text" name="attribute_sale_price[]" class="form-control" value="" required="required"></label><label class= "attribute_p">Market Price<input type="text" class="form-control" name="attribute_price[]" value="" required="required"></label></div>';
$("#sub_cat_listing").append(opt);
}
<?php } else { ?>
var val = $(this).val();
var deselected_val = params.deselected;
var selected_val = params.selected;
if (typeof(deselected_val) != "undefined")
{
var deselected_val = deselected_val.split(",");
var size_id=deselected_val[0];
var size_name=deselected_val[1];
size_id=size_id.toString();

if ($.inArray(size_id, yourArray) != -1)
{
for( var i = 0; i < yourArray.length; i++){
if ( yourArray[i] === size_id) {
yourArray.splice(i, 1);
}
}
$("#attribute2").val(yourArray);
}
$("#"+size_id).remove();
}
if (typeof(selected_val) != "undefined")
{
var selected_val = selected_val.split(",");
var size_id=selected_val[0];
var size_name=selected_val[1];
yourArray.push(size_id);
$("#attribute2").val(yourArray);
var opt='<div id="'+size_id+'"><label class="item_nameee attribute_p">'+size_name+'</label> <label>Our Price<input type="text" name="attribute_sale_price[]" class="form-control" value="" required="required"></label><label>Market Price<input type="text" class="form-control" name="attribute_price[]" value="" required="required"></label></div>';
$("#sub_cat_listing").append(opt);
}
<?php } ?>
});
</script>
<script src='<?php echo base_url(); ?>/public/admin/main_js/product_add.js'></script>
<div class="modal fade zoom_img_popup" id="zoom_img_as" role="dialog">
<div class="modal-dialog">
<div class="modal-body" style="text-align: center;">
<img id="modal_img" src="https://www.businessinsider.in/thumb.cms?msid=71543233&width=1200&height=900" class="img_zoomed_pop" >
</div>
</div>
</div>
<script src="https://cdn.ckeditor.com/ckeditor5/12.0.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
    .create( document.querySelector( '#ckeditor10' ) )
    .catch( error => {
        console.error( error );
    } );
    ClassicEditor
    .create( document.querySelector( '#ckeditor10_ar' ) )
    .catch( error => {
        console.error( error );
    } );

    $('.decimal').keyup(function(){
        var val = $(this).val();
        if(isNaN(val)){
            val = val.replace(/[^0-9\.]/g,'');
            if(val.split('.').length>2) 
                val =val.replace(/\.+$/,"");
        }
        $(this).val(val); 
    });
</script>