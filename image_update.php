<!-- View-->
<div class="form-group">
  <label>Product Image : </label>
  <input type="file" name="new_image" id="new_image" class="form-control">
  <input type="hidden" name="old_image" id="old_image" class="form-control" value="<?php echo $product['image']; ?>">
  <img src="<?php echo base_url().'uploads/'.$product['image']; ?>" style='height: 80px; width: 80px;'>
</div>
<!--end view-->


<!-- Controller Part-->
<?php
function update_products()
{
	$id=$this->input->post("id");
	$new_image=$this->input->post("new_image");
	$old_image=$this->input->post("old_image");
	if(empty($_FILES["new_image"]["name"]))
	{
		$qry=$this->Common_model->update_product_model($id,$old_image);
	}
	else
	{
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'gif|jpg|png';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('new_image'))
		{
			$error = array('error' => $this->upload->display_errors());

			$this->load->view('edit_product', $error);
		}
		else
		{
			$data = $this->upload->data();
			$new_image=$data["file_name"];
			$qry=$this->Common_model->update_product_model($id,$new_image);
		}
	}
}
?>
<!-- End Controller-->



<!-- Model Part-->
<?php

function update_product_model($id,$image)
{
	$this->db->where("id",$id);
	return $qry=$this->db->update("products",array("image"=>$image));
}
?>




<script>
	//for product updte  ye update_product_form  form id hai
    $("#update_product_form").on("submit",function(e){
    	e.preventDefault();
    	var url=BASE_URL+'Products/update_products';
    	$.ajax({
    		url : url,
    		method: 'POST',
    		data : new FormData(this),
    		contentType: false,
    		cache:false,
    		processData:false,
    		success:function(data)
    		{
    			alert("Success");
    		}
    	});
    });
</script>