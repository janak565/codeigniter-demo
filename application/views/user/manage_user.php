<table border=1; colspan="0"; colspace="0" width="100%">
	<?php if(!empty($this->session->flashdata('message'))){ ?>
	<tr>
		<th align="center" colspan=4><?php if(!empty($this->session->flashdata('message'))){ echo $this->session->flashdata('message'); } ?></th>
	</tr>
<?php }?>	
	<tr>
		<th align="center" width="25">
			<input type="checkbox" id="selecctall"/>		
		</th>
		<th align="center" width="25">
			Name
		</th>
		<th align="center" width="20">
			User Name
		</th>
		<th align="center" width="20">
			General
		</th>
		<th align="center" width="25">
			Photo
		</th>
			<th align="center" width="25">
			Action
		</th>
		</tr>
		<?php 
			if(isset($results) && !empty($results)){
				foreach($results as $data){
		?>
		<tr>
			<td align="center"><input class="checkbox1" type="checkbox" name="check[]" value="<?php echo $data->id;?>"/></td>
			<td align="center" width="25"><?php if(isset($data->first_name) && !empty($data->first_name)){ echo $data->first_name; } ?></td>
			<td align="center" width="20"><?php if(isset($data->user_name) && !empty($data->user_name)){ echo $data->user_name; } ?></td>
			<td align="center" width="20"><?php if(isset($data->general) && !empty($data->general)){ echo $data->general; } ?></td>
			<td align="center" width="25">
					<?php if(isset($data->avatar) && !empty($data->avatar)){ 
						if(isset($data->avatar) && !empty($data->avatar)){
							if(file_exists('upload/'.$data->avatar)){
					?>
								<img src="<?php echo DISPLAY_IMAGE_PATH.$data->avatar;?>" width="50" height="50"/>
					<?php 		
							}else{
					?>			
								<?php /*<img src="<?php echo DISPLAY_IMAGE_PATH.'no-avatar-image.jpg';?>" width="100" height="100"/>*/?>
					<?php					
							}	
						}	
					} ?>
			</td>
			<td align="center" width="10">
									  <a href="<?php echo SITE_URL.'/user/index?id='.$data->id?>">Edit</a>
									<a href="<?php echo SITE_URL.'/user/delete_user?id='.$data->id?>">Delete</a>	
			</td>
		</tr>	
		<?php
				}		
			}
		?>
	</tr>
	<tr>
		<td  align="left">
			<input class="deleteAll" type="button" name="delete" value="Delete"/>
		</td>	
		<td colspan=3 align="center">
			<?php foreach ($links as $link) {
					echo $link;
				}  
			?>

		</td>
	</tr>	
</table>
<script>
	var site_url = '<?php echo SITE_URL;?>';
	$(document).ready(function() {
    $('#selecctall').click(function(event) {  //on click
        if(this.checked) { // check select status
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"              
            });
        }else{
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                      
            });        
        }
    });
});		
$('.deleteAll').click(function(){
	var data = { 'user_ids' : []};
	 $(".checkbox1:checked").each(function() {
       data['user_ids'].push($(this).val());
		 console.log($(this).val());
      });	
	$.post( site_url+"/user/deleteAll", { data },function( data ) {
		if(data){
			window.location.href= site_url+'/user/manage_user';
		}
	});	
});		
</script>	