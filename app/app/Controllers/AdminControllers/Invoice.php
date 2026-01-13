<?php

namespace App\Controllers\AdminControllers;
use App\Models\UserModel;
use App\Libraries\CommonFun;
use App\Libraries\Pdf_create;

class Invoice extends AdminController
{   
    protected $comf;
    protected $pdf_create;
    function __construct()
    {
       $this->comf = new CommonFun();
       $this->pdf_create = new Pdf_create();
       $this->is_logged_in();
    }

    public function pdf($order_id = '')
    {
        $order_id = en_de_crypt($order_id,"d");
        $response = $this->pdf_create->get_print_pdf_list($order_id);
    }

    public function print_order($order_id)
    {
        $order_id = en_de_crypt($order_id,"d");

        ob_start();
        $data = $this->db_model->my_where('order_master','*',array('order_master_id' => $order_id));
        $currency = "$ ";

        if (empty($data)) 
        {
            echo ("<script LANGUAGE='JavaScript'>
                window.alert('No order found');
                window.setTimeout('window.close()', 5000); 
                </script>");die;
        }

        $data_items = $this->db_model->my_where('order_items','*',array('order_no' => $order_id));
        if (!empty($data_items)) 
        {
            foreach ($data_items as $kaey => $avalue) 
            {
                $quantity = $avalue['quantity'];
                $product_id = $avalue['product_id'];
                $price = $avalue['price']*100;
                $sub_total = $avalue['sub_total'];

                $p_info =  $this->db_model->my_where('product','*',array('id' => $product_id));
            }
        }

        $data_invoice = $this->db_model->my_where('order_invoice','*',array('order_no' => $order_id));
        $g_total =  $data[0]['net_total'];

        // echo "<pre>";
        // print_r($data_items);
        // die;


        $customer_id = $data[0]['user_id'];
        $users_details = $this->db_model->my_where('admin_users','*',array('id' => $customer_id));

        $item_data = array();

        foreach ($data_items as $key => $value)
        {
            $item_data[$value['item_id']] = $value;
        }
    

        extract($data);
        $transaction = $shipp = 0;$item_vendor = '';
        $product = $vendor = array();
        $info = array();

        foreach ($data_invoice as $key => $value)
        {
          $vendor[$value['seller_id']]['total'] = ($value['shipping_cost']);
          $shipp += $value['shipping_cost'];
          $index = 1;
          $str = explode(',', $value['item_ids']);
          foreach ($str as $k => $val)
          { 
            $info = $item_data[$val];
            $p_info =  $this->db_model->my_where('product','*',array('id' => $info['product_id']));

            if ($index == 1)
            {
                $info['rowspan'] = count($str);
                $info['ship'] = $value['shipping_cost'];
            }
            else{
                $info['rowspan'] = 0;
            }
            $index++;
            $product[$val] = $info;
          }
        }

        $aassd = '';

        // echo "<pre>";
        // print_r($data);
        // die;

         
        ?>  

        <!DOCTYPE html>
            <html>
               <head>
                <meta http-equiv="content-type" content="text/html; charset=utf-8" />
               </head>
               
               <body style="text-align: center;" >
                  <div style="border-radius: 10px;width: 100%;border: 0px solid red;display: inline-block;margin-top: 20px;background: #fff;padding: 20px;margin-bottom: 20px;">
                    <div style="float: left; width: 45%; ">
                        <img src="<?php echo base_url(); ?>/public/admin/images/logo.png" style="float: left; width: 200px;  " > 
                    </div>

                    <div style="float: left; width: 45%; ">
                        <div style=" font-size: 14px; line-height: 18px; margin-top:20px; float: right; text-align: right; ">
                            <span style="font-weight: 600;" >FoodyFood <br>
                        18/A, Loyalka Compound,<br> Ghatkopar West,<br> Mumbai - 400089 </span>
                        </div>
                    </div>
                    <div style="clear:both;"></div>
                    <div style="float: left; width: 45%; ">
                        <div style="background:#f1f1f1; padding: 10px 10px; border-radius: 5px; width:100%; text-align: left; font-size: 16px; font-weight: 600; color:#000; margin-top: 10px; margin-bottom: 20px; ">
                           BILL TO
                        </div>
                        <table style="float: left;  width: 100%;  text-align: left; font-size: 13px; color:#000; font-weight: 600; " >
                           <tr   >
                              <td style="padding:0px 8px 14px 10px;" >Name : </td>
                              <td style="padding:0px 8px 14px 0px; color: #000; font-weight: 400; " > <?php echo $data[0]['name']; ?> </td>
                           </tr>
                           <tr>
                              <td style="padding:0px 8px 14px 10px; vertical-align: text-top;" >Address:  </td>
                              <td style="padding:0px 8px 14px 0px; color: #000; font-weight: 400;" > <?php $full_address = $data[0]['address']; echo $full_address;  ?> </td>
                           </tr>
                           <tr>
                              <td style="padding:0px 8px 14px 10px;" >Phone:</td>
                              <td style="padding:0px 8px 14px 0px; color: #000; font-weight: 400;"><?php echo $data[0]['mobile_no'] ?></td>
                           </tr>
                           <?php echo $aassd; ?>
                        </table>
                    </div>
                     <div style="float: right; width: 45%; ">
                        <div style="background:#f1f1f1; padding: 10px 10px; border-radius: 5px; width:100%; text-align: left; font-size: 16px; font-weight: 600; color:#000; margin-top: 10px; margin-bottom: 20px; ">
                           INVOICE
                        </div>
                        <table style="float: right; width: 100%;  text-align: left; font-size: 13px; color:#000; font-weight: 600; " >
                           <tr   >
                              <td style="padding:0px 8px 14px 10px;" >Order Date/Time : </td>
                              <td style="padding:0px 8px 14px 0px; color: #000; font-weight: 500;" > <?php $date = date('M j, Y, g:i a', strtotime($data[0]['order_datetime'])); echo $date; ?></td>
                           </tr>
                           <tr>
                              <td style="padding:0px 8px 14px 10px;" >Invoice Number:  </td>
                              <td style="padding:0px 8px 14px 0px; color: #000; font-weight: 500;" ><?php echo $data[0]['order_master_id']; ?> </td>
                           </tr>
                           <tr>
                              <td style="padding:0px 8px 14px 10px;" >Order By:  </td>
                              <td style="padding:0px 8px 14px 0px; color: #000; font-weight: 500; " ><?php echo $data[0]['name']; ?> </td>
                           </tr>
                           <tr>
                              <td style="padding:0px 8px 14px 10px;" >Payment Mode:  </td>
                              <td style="padding:0px 8px 14px 0px; color: #000; font-weight: 500;" > <?php echo $data[0]['payment_mode']; ?>   </td>
                           </tr>
                           <tr>
                              <td style="padding:0px 8px 14px 10px;" > Payment Status:  </td>
                              <td style="padding:0px 8px 14px 0px; color: #000;font-weight: 500; " > <?php echo $data[0]['payment_status']; ?> </td>
                           </tr>
                           <?php if ($data[0]['delivery_note']): ?>
                               <tr>
                                  <td style="padding:0px 8px 14px 10px;" > Order Note:  </td>
                                  <td style="padding:0px 8px 14px 0px; color: #000;font-weight: 500; " ><?php echo $data[0]['delivery_note']; ?> </td>
                               </tr>
                           <?php endif ?>
                           
                        </table>
                     </div>
                     <div style="clear:both;"></div>
                     <table class="tbet" style="width: 100%; font-size: 14px; font-weight: 600; margin-top: 20px; text-align: center; "  >
                        <tr style="border:1px solid #555;" >
                           <td style="width: 10%;padding: 7px 0px" >No. </td>
                           <td style="width: 25%;padding: 7px 0px" >Product Name </td>
                           <td style="width: 10%;padding: 7px 0px" >Quantity </td>
                           <td style="width: 10%;padding: 7px 0px" >Unit </td>
                           <td style="width: 10%;padding: 7px 0px" >Rate (Incl. of Tax)</td>
                           <td style="width: 15%;padding: 7px 0px" >Total </td>
                        </tr>

                        <?php

                    if ($data_items) 
                    { 
                      $total = $ptax = $pcom = $vendor_total = $grand_total = 0;
                      $i=1;
                      $oids='';
                      foreach($data_items as $key1 => $row)
                      {   


                        $attribute = $row["attribute"];
                        if (!empty($attribute))
                        {
                            $product_name = $row["product_name"].' ('. $attribute .')';
                        }
                        else{
                            $product_name = $row["product_name"];
                        }

                        $product_cust_data = '';

                        if (!empty($row['items_extra_data']))
                        {
                            foreach ($row['items_extra_data'] as $pkey => $pvalue)
                            {
                                if ($pvalue['price'] == '0')
                                {
                                    $c_price = 'Free';
                                }
                                else
                                {
                                    $c_price = $currency .''.$pvalue['price'];
                                }
                                $product_cust_data.='<p>'.$pvalue['name'].' :- '.$c_price.'</p>';
                            }
                        }


                        $product_price = ($row["price"] * $row['quantity']);
                        $total = $total + $product_price;
                        $pcom =0;

                        ?>              
                    
                        <tr style="border:1px solid #666; font-weight: 500; " >
                           <td style="padding: 7px 0px" ><?php echo $key1+1; ?></td>
                           <td style="padding: 7px 0px" ><?php echo $product_name; ?></td>
                           <td style="padding: 7px 0px" ><?php echo $row['quantity']; ?></td>
                           <td style="padding: 7px 0px" >AS  </td>
                           <td style="padding: 7px 0px" ><?php echo $row["price"]; ?> </td>
                           <td style="padding: 7px 0px" ><?php echo ($row["price"] * $row['quantity']); ?></td>
                        </tr>

                    <?PHP }

                     $grand_total = $total + $shipp  + $pcom;
                     $vendor_total = $total + $shipp  - $pcom;

                     } ?> 

                       
                        
                        
                     </table>

                     <div style="float: right; width:50%; ">
                        <table style="width: 100%; font-size: 14px; font-weight: 600; text-align: center; "  >
                            <tr style=" font-size: 14px; border:1px solid #444;  font-weight: 600; text-align: right; border-top: none;" >
                           <td colspan="5" style=" text-align: right; padding:0px 20px 0px 0px;" >
                              Product Amount:   
                           </td>
                           <td colspan="2" style="  text-align: right; padding: 7px 20px" ><?php echo $currency; ?> <?php echo number_format($data[0]['sub_total'], 2); ?></td>
                        </tr>
                        <tr style=" font-size: 14px; border:1px solid #444;  font-weight: 600; text-align: right; " >
                           <td colspan="5" style=" text-align: right; padding:0px 20px 0px 0px;" >Shipping Amount: </td>
                           <td colspan="2" style="  text-align: right; padding: 7px 20px" ><?php echo $currency; ?> <?php echo $data[0]['shipping_charge']; ?></td>
                        </tr>
                        <tr style=" font-size: 14px; border:1px solid #444; font-weight: 600; text-align: right; " >
                           <td colspan="5" style=" text-align: right; padding:0px 20px 0px 0px;font-size: 16px;font-weight: bolder;" >Tax Amount:  </td>
                           <td colspan="2" style="  text-align: right; padding: 7px 20px" ><?php echo $currency; ?> <?php echo $data[0]['tax'] ; ?> </td>
                        </tr>
                        <tr style=" font-size: 16px; border:1px solid #444; font-weight: 600; text-align: right; " >
                           <td colspan="5" style=" text-align: right; padding:0px 20px 0px 0px;font-size: 16px;font-weight: bolder;" >Amount to Pay:    </td>
                           <td colspan="2" style="  text-align: right; padding: 7px 20px" > <?php echo $currency; ?> <?php echo $g_total ; ?> </td>
                        </tr>
                        
                        </table>
                     </div>

                    <div style="float: right;width: 50%;height: 126px;border: 1px solid;border-top: none;border-right: none;">
                        <div style="">
                            <!-- <div style="">
                                <img src="<?php echo base_url(); ?>assets/QR.png" style="float: right;width: 100px;margin-right: 13px; margin-top: 20px;" >
                            </div> -->
                            <div style="float: right; width: 100%; ">
                               <!-- <div style="font-weight: 600; font-size: 13px; margin-top: 20px;">Scan this QR for payment</div> -->
                               <!-- <div style="font-weight: 600; font-size: 14px; margin-top: 8px;">A R TECHNOLOGIES</div> -->
                               <div style="font-weight: 600; font-size: 13px; margin-top: 16px; margin-bottom: 9px;">Customer Care - +91-8149169115<br></div>
                               <div style="font-weight: 600; font-size: 13px; margin-top: 4px; margin-bottom: 9px;">Email - info@foodyfood.in<br></div>
                               <div style="font-weight: 600; font-size: 13px; margin-top: 4px; margin-bottom: 9px;">Website - https://foodyfood.in<br></div>
                               <div style="font-weight: 600; font-size: 13px; margin-top: 4px; margin-bottom: 9px;">Note : This is a computer generated bill <br></div>
                            </div>
                         </div>
                    </div>

                     <div class="clear:both;"></div>
                  </div>
               </body>
               <style type="text/css">
                html, body{
                padding: 0px;
                margin: 0px;
                background: #f1f1f1;
                }
                *{
                font-family: arial;
                } 
                div{
                box-sizing: border-box;
                }
                table, th{
                border-collapse: collapse;
                }
                .tbet td {
                border: 1px solid;
                }
                html, body {
                padding: 10px;
                padding-top: 0px;
                background: #f1f1f1;
                }
                </style>

            </html>

            

        <?php

        echo ("<script LANGUAGE='JavaScript'>
                window.print();
                </script>");die;
        die;
    }

}
