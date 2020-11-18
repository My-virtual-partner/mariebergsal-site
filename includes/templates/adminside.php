<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php 

include_once($_SERVER["DOCUMENT_ROOT"].'/wp-config.php');


global $wpdb;
$tablename = $wpdb->prefix.'reservation';
if(isset($_GET['add-reservation'])){

if(isset($_POST['submit'])){

$wpdb->insert( $tablename, array('name' => $_POST['add-reservation'],'links' => $_POST['links']),  array( '%s','%s'));
}
if(isset($_POST['update'])){

$wpdb->update($tablename,array('name' => $_POST['add-reservation'],'links' => $_POST['links']),array( 'ID' => $_POST['id'] ));
header("Location: ".get_site_url()."/adminside?add-reservation=1");
}
if(!empty($_GET['edit'])){
	$id= $_GET['edit'];
	$editData = $wpdb->get_results("SELECT * FROM ". $tablename." WHERE id='".$id."'");

}

}
$result = $wpdb->get_results("SELECT * FROM ". $tablename);
 ?>

<div class="topnav">

  <a  href="/system-dashboard"><i class="fa fa-angle-double-left" style="font-size:17px;padding: 0 9px;"></i>System Dashboard</a>
  <a class="<?php if(isset($_GET['add-reservation'])){ echo "active";}?>" href="/adminside?add-reservation=1">Add Reservation</a>
  <a class="<?php if(isset($_GET['all-project'])){ echo "active";}?>" href="/adminside?all-project=1">ALL Project</a>

</div>
<div class="tabs">
<?php if(isset($_GET['add-reservation'])){ ?>
	<ul class="tab-links">
	
		<li class="active"><a href="#tab1">Add Reservation</a></li>
		<li><a href="#tab2">All Reservation</a></li>


	</ul>

	<div class="tab-content">
	
		<div id="tab1" class="tab active">
<form method="POST" action="">
    <label for="add-reservation">Reservation Name</label>
    <input type="text"  name="add-reservation" value="<?php echo ($editData[0]->name)?$editData[0]->name:'';  ?>" placeholder="Add Reservation..">
<?php if(!empty($_GET['edit'])){ ?>
<input type='hidden' name="id" value="<?php echo ($editData[0]->id)?$editData[0]->id:'';  ?>"/>
<?} ?>
 <label for="add-reservation">Reservation Name</label>
<input type="text" name="links" value="<?php echo ($editData[0]->links)?$editData[0]->links:'';  ?>" placeholder="Add Link.." />
    <input type="submit" name="<?php echo empty($_GET['edit'])?'submit':'update';  ?>" value="Update">
  </form>
		</div>

		<div id="tab2" class="tab">
			<table>
      <tr>
	  <th>id</th>
        <th>Reservation</th>
		<th>Project Type</th>
		<th>Link</th>
        <th>Action</th>
      </tr>
	  <?php foreach($result as $value){?>
      <tr>
	  <td><?=$value->id?></td>
        <td><?=$value->name?></td>
		 <td><?=$value->project_type?></td>
		 <td><?=$value->links?></td>
        <td><a href="/adminside?add-reservation=1&edit=<?=$value->id?>">Edit</a></td>
      </tr>
      <?php } ?>
    </table>
		</div>

	

	

	</div>
<?php }	if(isset($_GET['all-project'])){
	
	if(!empty($_POST['submit'])){

	 $newprojects = $_POST['newprojects'];
	
	if(empty($_POST['newproduct'])){ 
	$project_type[] = $newprojects;
	 $editDatas = $wpdb->get_results("SELECT * FROM ". $tablename." WHERE project_type like'%".$newprojects."%'");

	
	
	
	
	
	
	if(count($editDatas) != 0){
foreach($editDatas as $newValue){
$hacker = unserialize($newValue->project_type);

$pos = array_search($newprojects,$hacker);
unset($hacker[$pos]);


$wpdb->update($tablename,array('project_type' =>!empty($hacker)?serialize($hacker):''),array( 'ID' =>$newValue->id ));

	}
 
	} 

	$checkData = $wpdb->get_results("SELECT * FROM ". $tablename." WHERE  ID = '".$_POST['newreservation']."'");


	foreach($checkData as $key){
 		if(!empty($key->project_type))
	$newValue = array_merge($project_type,unserialize($key->project_type));
	else
	$newValue = $project_type; 
	}

if(!empty($_POST['newreservation'])){
$filtertype = array_unique($newValue);  
$wpdb->update($tablename,array('project_type' =>serialize($filtertype)),array('ID' => $_POST['newreservation']));
		}
		}
	}
	


if(empty($newprojects)){ 
$newprojects = 'fireplace_with_assembly';
}
$result = $wpdb->get_results("SELECT * FROM ". $tablename);
$project_roles_steps = 	 array("hem_visit_sale_system"=>"Hembesök","fireplace_with_assembly"=>"Eldstad inklusive montage","service"=>"Service och reservdelar","accesories"=>"Kassa ","changes_and_new_work"=>"ÄTA","self_builder"=>"Självbyggare",'hansa_offert_for_old_offert'=>'Specialoffert','solcellspaket'=>'Solcellspaket');


 ?>
		<form id="formnew" method='post'>
<h3>Select Project Type</h3>
<select class="newitems" name="newprojects" id='newprojects'><?php 
   foreach ($project_roles_steps as $key => $value) { ?>
<option <?php if($newprojects == $key) {echo "selected";} ?> value='<?php echo $key; ?>'><?php echo $value; ?></option>
<?php } ?>
 </select>
<table cellpadding="10" style="float:left; margin-right: 35px;">
	<tr>
    <th>Choose Reservation</th>
    <th>Choose Reservation Standard</th>
  </tr>
  <tr><td>None of choose</td>
<td><input class='example' type='radio'  name='newreservation' value='' ></td>
</tr>
 <?php foreach($result as $value){?>

<tr><td><?=$value->name?></td>
<td><input class='example' type='radio' <?php if(in_array($newprojects,unserialize($value->project_type))){ echo "checked"; }  ?> name='newreservation' value='<?=$value->id?>' ></td>
</tr>
<?php } ?>
</table>
<input type="hidden" id="newproduct" name="newproduct" value="" />
<input type="submit" name="submit" id="submits" value="submit"/></div>
</form>
	  <?php } ?>
</div>

<style>
.tabs {
	width:100%;
	display:inline-block;
}


	.tab-links:after {
	display:block;
	clear:both;
	content:'';
}

.tab-links li {
	margin:0px 5px;
	float:left;
	list-style:none;
}

.tab-links a {
	padding:9px 15px;
	display:inline-block;
	border-radius:3px 3px 0px 0px;
	background:#7FB5DA;
	font-size:16px;
	font-weight:600;
	color:#4c4c4c;
	transition:all linear 0.15s;
	text-decoration: none;
}

.tab-links a:hover {
	background:#a7cce5;
	text-decoration:none;
}

li.active a, li.active a:hover {
	text-decoration: underline;
	color:#4c4c4c;
}


.tab-content {
	padding:15px;
	border-radius:3px;
	box-shadow:-1px 1px 1px rgba(0,0,0,0.15);
	background:#fff;
}

.tab {
	display:none;
}

.tab.active {
	display:block;
}
.tabs input[type=text], select {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

.tabs input[type=submit] {
  width: 100%;
  background-color: #4CAF50;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.tabs input[type=submit]:hover {
  background-color: #45a049;
}

.tabs div {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
}
     .tab table, .tab th, .tab td {
      padding: 10px;
      border: 1px solid black; 
      border-collapse: collapse;
      }
	
.topnav {
  overflow: hidden;
  background-color: #333;
}

.topnav a {
  float: left;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
}

.topnav a:hover {
  background-color: #ddd;
  color: black;
}

.topnav a.active {
  background-color: #4CAF50;
  color: white;
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<Script>
$(document).ready(function(jQuery){
	jQuery('#newprojects').on('change',function(){
	jQuery('#newproduct').val(1);
	 jQuery('#submits').trigger("click");
});
	jQuery('.tabs .tab-links a').on('click', function(e) {
		var currentAttrValue = jQuery(this).attr('href');

		// Show/Hide Tabs
		jQuery('.tabs ' + currentAttrValue).show().siblings().hide();

		// Change/remove current tab to active
		jQuery(this).parent('li').addClass('active').siblings().removeClass('active');

		e.preventDefault();
	});
});
</script>