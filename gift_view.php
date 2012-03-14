<div class="product_cont margin_t">
    <div class="product_cont_tops">
    <?php //echo $this->session->userdata('event_id')." - ".$this->session->userdata('relation_id');?>

    <?php if(!isset($page_size)){
			$page_size = ($this->session->userdata('page_size'))?$this->session->userdata('page_size'):GIFT_PER_PAGE;
	   }
    ?>
    <div class="ul_input_right">
	<h2 class="left"><?php echo $sect4_title;?></h2> 
	<ul>
             <li><span> items per page</span></li>
	     <li>
	     <select onchange="changePageSize(this,'<?php echo $this->session->userdata('relation_id');?>','<?php echo $this->session->userdata('event_id');?>','<?php echo (isset($prange) && !empty($prange))?$prange:0;?>');" class="txt_select_tiny">  
		<option <?php echo ($page_size==12)?'selected="selected"':'';?> value="12">12</option>  
		<option <?php echo ($page_size==24)?'selected="selected"':'';?> value="24">24</option>  
		<option <?php echo ($page_size==48)?'selected="selected"':'';?> value="48">48</option>
	     </select>		
	     </li>
            <li><span>Show :</span></li>
	</ul>
    </div>
    <div class="clear"></div>
  <?php // *** pagination configuration
	if(!$this->session->userdata('show_gift')){
		if(isset($prange) && !empty($prange)){
			$page_config = $this->home_model->page_product_config($page_size,$this->session->userdata['current_page'],$this->home_model->count_all_gifts($this->session->userdata('relation_id'),$this->session->userdata('event_id'),$prange));
    			$page_data['config'] = $page_config;
		}else{
			$page_config = $this->home_model->page_product_config($page_size,$this->session->userdata['current_page'],$this->home_model->count_all_gifts($this->session->userdata('relation_id'),$this->session->userdata('event_id')));
    			$page_data['config'] = $page_config;
			
		}
	}else{
		if(!isset($checked_items)){
			$checked_items = $this->session->userdata('checked_items');
		}
		if(isset($prange) && !empty($prange)){
			$page_config = $this->home_model->page_product_config($page_size,$this->session->userdata['current_page'],$this->home_model->count_all_gifts($checked_items,'',$prange));
    			$page_data['config'] = $page_config;
		}else{
			$page_config = $this->home_model->page_product_config($page_size,$this->session->userdata['current_page'],$this->home_model->count_all_gifts($checked_items,''));
    			$page_data['config'] = $page_config;
			
		}
	}
		//print_r($page_config);
  ?>
   
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="opacity">
    <tbody>
    <?php
    if($this->session->userdata('show_gift')){
	if(isset($prange) && !empty($prange)){
		$gift_array = $this->home_model->get_gifts('','',$page_config,$prange);
	}else{
		$gift_array = $this->home_model->get_gifts('','',$page_config);
		//print_r($gift_array);die;
	}
    }else  if(isset($prange) && !empty($prange)){
	
	$gift_array = $this->home_model->get_gifts($this->session->userdata('relation_id'),$this->session->userdata('event_id'),$page_config,$prange);
    }else{
	
	$gift_array = $this->home_model->get_gifts($this->session->userdata('relation_id'),$this->session->userdata('event_id'),$page_config);
    }
    $i=0;
    if(!empty($gift_array)){
	//echo count($gift_array);
        foreach($gift_array as  $k=>$gift){?>

        <!-- calculate the $star_number -->
        <?php $gift['answer'] = (!isset($gift['answer']) || empty($gift['answer']))?0:$gift['answer'];
                    switch(true){
                            case ($gift['answer']<floatval($gift['max_score']*0.2)): $star_number=1;break;
                            case (($gift['answer']<floatval($gift['max_score']*0.4)) && ($gift['answer']>=floatval($gift['max_score']*0.2))):$star_number=2;break;
                            case (($gift['answer']<floatval($gift['max_score']*0.6)) && ($gift['answer']>=floatval($gift['max_score']*0.4))):$star_number=3;break;
                            case (($gift['answer']<floatval($gift['max_score']*0.8)) && ($gift['answer']>=floatval($gift['max_score']*0.6))):$star_number=4;break;
                            case ($gift['answer']>=$gift['max_score']*0.8):$star_number=5;break;

                            }
        ?>
    <!-- show the gift in the gift section only if the  SHOW_GIFT_STARS<=$star_number -->
    <?php if(SHOW_GIFT_STARS<=$star_number){
    if($i%GIFT_PER_ROW==0){?>
    <tr>
    <?php }?>
    <td>
         <div class="gift">
    		<div>
			<?php if(file_exists('./web/images/gifts/'.$gift['gift_id'].'_thumb.jpg')){?>
			<a href="#<?php //echo $gift['giftlink'];?>" target="_self" onclick="saveToDB('<?php echo $this->session->userdata('user_id');?>','<?php echo $this->session->userdata('relation_id');?>','<?php echo $this->session->userdata('event_id');?>','<?php echo $gift['gift_id'];?>','<?php echo $gift['giftlink'];?>');popup_en('<?php echo $gift['giftlink'];?>');">
				<img class="gift_border" src="<?php echo site_url();?>web/images/gifts/<?php echo $gift['gift_id'];?>_thumb.jpg" alt=""/></a>
			<?php }else if($gift['giftfit']==0){?>
			<a href="#<?php //echo $gift['giftlink'];?>" target="_self" onclick="saveToDB('<?php echo $this->session->userdata('user_id');?>','<?php echo $this->session->userdata('relation_id');?>','<?php echo $this->session->userdata('event_id');?>','<?php echo $gift['gift_id'];?>','<?php echo $gift['giftlink'];?>');popup_en('<?php echo $gift['giftlink'];?>');"><img  width="135px" style="margin-top:60px;margin-bottom:60px" src="<?php echo $gift['giftimagelink']?>" alt=""/></a>
			<?php }else{?>
			<a href="#<?php //echo $gift['giftlink'];?>" target="_self" onclick="saveToDB('<?php echo $this->session->userdata('user_id');?>','<?php echo $this->session->userdata('relation_id');?>','<?php echo $this->session->userdata('event_id');?>','<?php echo $gift['gift_id'];?>','<?php echo $gift['giftlink'];?>');popup_en('<?php echo $gift['giftlink'];?>');"><img  height="135px" width="135px" src="<?php echo $gift['giftimagelink']?>" alt=""/></a>
			<?php }?>
    			<span class="product_detail_small"><?php echo $gift['giftname'];?></span>
    			<!--<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit Sed pellentesque.</p>-->
		</div>
		<div class="clear"></div>
		
		<?php
		if (isset($star_number) && SHOW_RATING==1){?>
		<div>
		<span class="product_detail_small left">TruGiftSelect Rating &nbsp;</span>
		<ul class="padding_tb"><li>
			<?php for($j=1;$j<$star_number+1;$j++){?>
			<span class="star"></span>
			<?php } ?>
			<?php for($j=$star_number+1;$j<=5;$j++){?>
			<span class="star_grey"></span>
			<?php } ?>
		</li></ul>
		</div>
		<?php }else{ ?>
			<div>
				<span class="product_detail_small left padding_tb">&nbsp;</span>
			</div>
		<?php }?>
    		<div class="clear"></div>

    		
		<div class="product_price_red_small">$<?php echo number_format($gift['giftnewamount'],2);?></div>
		<div><?php echo "order_by:".$gift['answer']."; max score:".$gift['max_score'];?></div>
    		<!--<span class="detail_btn"><a href="#" onclick="saveToDB('<?php echo $this->session->userdata('user_id');?>','<?php echo $this->session->userdata('relation_id');?>','<?php echo $this->session->userdata('event_id');?>','<?php echo $gift['gift_id'];?>','<?php echo $gift['giftlink'];?>');popup_en('<?php echo $gift['giftlink'];?>');"><img border="0" src="<?php echo site_url();?>web/images/detail_btn.gif" alt="<?php echo $gift['giftname'];?>"/></a></span>-->
    	  </div>
    </td>
    
    <?php
        if(($i+1)%GIFT_PER_ROW==0){
           ?></tr><?php
        }
        $i++;
    ?>
    <?php } //end if SHOW_GIFT_STARS<=$star_number?>
    
    <?php    } //end foreach
    }else{ ?>
       <tr><td width="100%"><?php echo $this->lang->line('no_product');?></td></tr>
    <?php }?>
    </tbody>
   </table>
   
    <!-- BOF pagebar bottom-->
    <div class="pagebar margin_t g_t_c gray_bg">
	<?php  $this->load->view('details/pagination',$page_data);?>
    </div>
    <!-- EOF pagebar bottom-->