<?php
	function database(){
		$user ="root";
    	$pass = "root";
   		$dbh = new PDO('mysql:host=localhost;dbname=topobserver;port=8889',$user, $pass);
		return $dbh;
	}

	function top_left($user_fname){
		$info ='<div>
				<h3>Welcome, '.$user_fname.'</h3>
			</div>';
			return $info;
	}

	function get_logo($logo_id){
		$dbh = database();
		$stmt = $dbh->prepare('SELECT logo FROM company WHERE id = '."$logo_id".';');
		$stmt->execute(); 
    	$result = $stmt->fetchall(PDO::FETCH_ASSOC);
    	return $result['0']['logo'];
	}

	function db_dashboard_query($user_id){
		$dbh = database();
		$stmt = $dbh->prepare('SELECT c.id, company FROM user u LEFT JOIN company_permissions cp ON cp.user_id = u.id LEFT JOIN company c ON c.id = cp.company_id WHERE u.id = '."$user_id".';');
		$stmt->execute(); 
   		$result = $stmt->fetchall(PDO::FETCH_ASSOC);
   		return $result;
	}

	function dashboard_metrics($row_id){
		$dbh = database();
		$stmt2 = $dbh->prepare('SELECT company_id, burnrate, revenue, visitors, date, DATE_FORMAT(date, "%b %Y") AS month FROM company_data WHERE company_id = '."$row_id".' order by date desc limit 1;');
		$stmt2->execute();
    	$info2 = $stmt2->fetchall(PDO::FETCH_ASSOC);
    	return $info2;
    }

    function dashboard_funding($row_id){
    	$dbh = database();
    	$stmt1 = $dbh->prepare('SELECT company_id, SUM(funding) "Total Funding" FROM company_data WHERE company_id = '."$row_id".' GROUP BY company_id;');
		$stmt1->execute();
    	$info = $stmt1->fetchall(PDO::FETCH_ASSOC);
    	return $info;
    }

	function left_nav($user_id){
		$result = db_dashboard_query($user_id);
		if (isset($result['0']['company'])){
			$left_nav = '<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">';
			foreach ($result as $row) {
			$row_id = $row['id'];
			$left_nav .= '
				<div class="panel panel-default">
			    	<div class="panel-heading" role="tab" id="heading'.$row['id'].'">
			      		<h4 class="panel-title">
			        		<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse'.$row['id'].'" aria-expanded="false" aria-controls="collapse'.$row['id'].'">
			          			'.$row['company'].'
			        		</a>
			      		</h4>
			    	</div>
			    	<div id="collapse'.$row['id'].'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading'.$row['id'].'">
					      		<div class="panel-body">
					        		<ul>';

			    	
					$info2 = dashboard_metrics($row_id);
			    	foreach ($info2 as $metric) {
			    		$left_nav .='<li>'.$metric['month'].'</li>
			    			 <li>Burnrate: $'.number_format($metric['burnrate']).'</li>
			    			 <li>Revenue: $'.number_format($metric['revenue']).'</li>
			    			 <li>Unique Visitors: '.number_format($metric['visitors']).'</li>';
					}
					$info = dashboard_funding($row_id);
			    	foreach ($info as $fund) {
			    		$left_nav .='<li>Total Funding: $'.number_format($fund['Total Funding']).'</li>';
					}
			$left_nav .= '</ul>
					      		</div>
					    	</div>
					  	</div>';

			}
			$left_nav .= '</div>';
			return $left_nav;
		}else{
			return null;
		}
		
	}

	function company_info($cid){
		$dbh = database();
		$companyinfo = $dbh->prepare('SELECT * FROM company WHERE id = '.$cid.';');
		$companyinfo->execute();
		$compinfo = $companyinfo->fetchall(PDO::FETCH_ASSOC);
		return $compinfo;
	}

	function thumbnails($user_id){
		$result = db_dashboard_query($user_id);
		$thumbnail ='';
		if ($result[0]['id']!== null){
	
			foreach ($result as $thumb) {
				$cid = $thumb['id'];
				$compinfo = company_info($cid);
				
				$thumbnail .= '
				<div class="col-xs-6 col-md-4">
					<div class="thumbnail">
		      			<img src="img/logos/'.$compinfo['0']['logo'].'" alt="...">
		  				<div class="caption">
		    				<h4>'.$compinfo['0']['company'].'</h4>
			        		<h5>Dayton, OH</h5>
			        		<div id="chart'.$cid.'" style="width:100%; height:200px;"></div>
			        		<p><a href="company.php?id='.$compinfo['0']['id'].'" class="btn btn-primary" role="button">More</a></p>
			      		</div>
						</div>
					</div>';
			}
			return $thumbnail;
		}else{
			return "<h3>Add a new Company to get started!</h3>";
		}
	}

	function small_revenue($chartid){
		$dbh = database();
		$chart = $dbh->prepare('SELECT c.company, revenue, date, DATE_FORMAT(date, "%b") AS month FROM company_data cd LEFT JOIN company c ON c.id = cd.company_id WHERE company_id = '."$chartid".' order by date ASC limit 3;');
		$chart->execute();
	   	$chartinfo = $chart->fetchall(PDO::FETCH_ASSOC);
	   	return $chartinfo;
	}

	function dashboard_revenue($user_id){
		$result = db_dashboard_query($user_id);
		$chart_sm ="";
		if ($result[0]['id']!== null){

			foreach ($result as $chart) {
				$chartid = $chart['id'];
				$chartinfo = small_revenue($chartid);
	    		$revenue = '[';
	    		$chartDate = '[';
	    		if(isset($chartinfo['0']['company'])){
	    			$chartTitle= $chartinfo['0']['company'];
	    		}
	    		
	    		foreach ($chartinfo as $infochart) {
	    			$revenue .= $infochart['revenue'].',';
	    			$chartDate .= '\''.$infochart['month'].'\',';
	    		}
	    		
	    		$useable_revenue = substr_replace($revenue, "]", -1);
	    		$useable_month = substr_replace($chartDate, "]", -1);
	    		
	    		if(isset($chartTitle)){
					$chart_sm .= "
					<script>
					    $(function () { 
					    $('#chart".$chartid."').highcharts({
					        credits: {
					      		enabled: false
					  		},
					        chart: {
					            type: 'line'

					        },
					        title: {
					            text: 'Monthly Revenue'
					        },
					        xAxis: {
					            categories: ".$useable_month."
					        },
					        yAxis: {
					            title: {
					                text: 'Amount'
					            }
					        },
					        series: [{
					            name: '".$chartTitle."',
					            data: ".$useable_revenue."
					        }]
					    });
					});
					    </script>";
					return $chart_sm;
				}
			}
			
		}

	}

	function company_chart_metrics($company_id){
		$dbh = database();
		$chart = $dbh->prepare('SELECT * , date, DATE_FORMAT(date, "%b") AS month FROM company_data cd WHERE company_id = '."$company_id".' order by date ASC limit 12;');
		$chart->execute();
	   	$chartinfo = $chart->fetchall(PDO::FETCH_ASSOC);
	   	return $chartinfo;
	}

	function chart_title($chart_id){
		$dbh = database();
		$chart = $dbh->prepare('SELECT * FROM metric WHERE id = '."$chart_id".';');
		$chart->execute();
	   	$chart_title = $chart->fetchall(PDO::FETCH_ASSOC);
	   	return $chart_title;
	}

	function line_chart($month,$value,$title,$id){
		$chart = "<script>
		    $(function () { 
		    $('#chart".$id."').highcharts({
		        credits: {
		      		enabled: false
		  		},
		        chart: {
		            type: 'line'

		        },
		        title: {
		            text: '".$title."'
		        },
		        xAxis: {
		            categories: ".$month."
		        },
		        yAxis: {
		            title: {
		                text: 'Amount'
		            }
		        },
		        series: [{
		            name: '".$title."',
		            data: ".$value."
		        }]
		    });
		});
		    </script>";
		return $chart;
	}

	function company_chart($company_id,$chart_id,$chart_type){
		$chartinfo = company_chart_metrics($company_id);
		$chart_title = chart_title($chart_id);
		// print_r($chartinfo);
		// echo '<br>';
		// print_r($chart_title);
		// die;
		$value = '[';
		$months = '[';
		$title = $chart_title['0']['title'];
		foreach ($chartinfo as $chart_value) {
			$value .= $chart_value[$chart_title['0']['metric']].',';
			$months .='\''.$chart_value['month'].'\',';
		}
		$useable_value = substr_replace($value, "]", -1);
		$useable_month = substr_replace($months, "]", -1);
		// echo $useable_value;
		// echo $useable_month;
		// echo $title;
		if ($chart_type ==='1'){
			$chart=line_chart($useable_month, $useable_value, $title,$chart_id);
			return $chart;
		}else{
			echo "No Chart Types available";
		}	
	}

	function add_metrics($company_id, $cid){
		if($cid==="new"){
			$addinfo ='<tr>';
			$addinfo .="<td><input type'date' name='date' id='date' placeholder='2015-01-30'required/></td>";
			$addinfo .="<td><input type='number' name='burnrate' value'0' id='burnrate' required/></td>";
			$addinfo .="<td><input type='number' name='revenue' value'0' id='revenue' required/></td>";
			$addinfo .="<td><input type='number' name='visitors' value'0' id='visitors' required/></td>";
			$addinfo .="<td><input type='number' name='funding' value'0' id='funding' required/></td>";
			$addinfo .="<td><input type='submit' class='btn btn-primary btn-sm'></input></td>";
			return $addinfo;
		}
		// echo $addinfo;
		// echo"pi";
		
	}

	function edit_metrics($company_id, $cid){
		$dbh = database();
		$stmt = $dbh->prepare('SELECT * FROM company_data cd WHERE company_id = '."$company_id".' order by date ASC;');
		$stmt->execute(); 
    	$result = $stmt->fetchall(PDO::FETCH_ASSOC);
    	$info ="";
    	foreach ($result as $metric){
    		if($metric['id']===$cid){
    			$info .= "<tr>";
    			$info .="<input type='hidden' name='id' value='".$metric['id']."'</input>";
    			$info .="<td><input type='date' name='date' value='".$metric['date']."'</input></td>";
    			$info .="<td><input type='number' name='burnrate'value='".$metric['burnrate']."'</input></td>";
    			$info .="<td><input type='number' name='revenue' value='".$metric['revenue']."'</input></td>";
    			$info .="<td><input type='number' name='visitors'value='".$metric['visitors']."'</input></td>";
    			$info .="<td><input type='number' name='funding' value='".$metric['funding']."'</input></td>";
    			$info .="<td><input type='submit' class='btn btn-primary btn-sm'></input></td>";
    			$info .="</tr>";
    		}else{
	    		$info .= "<tr>";
	    		$info .="<td>".$metric['date']."</td>";
	    		$info .="<td>".$metric['burnrate']."</td>";
	    		$info .="<td>".$metric['revenue']."</td>";
	    		$info .="<td>".$metric['visitors']."</td>";
				$info .="<td>".$metric['funding']."</td>";
				$info .="<td> <a href='editmetric.php?id=".$company_id."&cid=".$metric['id']."' type='button' class='btn btn-primary btn-sm'>Edit</a></td>";
				$info .="</tr>";
			}
    	}
    	return $info;
	}

	function company_funding($company_id){
		$dbh = database();
		$stmt = $dbh->prepare('SELECT company_id, SUM(funding) "Total Funding", SUM(revenue) "Total Revenue" FROM company_data WHERE company_id = '."$company_id".' GROUP BY company_id;');
		$stmt->execute(); 
    	$result = $stmt->fetchall(PDO::FETCH_ASSOC);
    	if (isset($result['0']['Total Funding'])){
    		$info ="<h4>Total Funding: $".number_format($result['0']['Total Funding'])."</h4>";
    	}else{
    		$info ="<h4>Total Funding: $0</h4>";
    	}
    	if(isset($result['0']['Total Revenue'])){
    		$info .="<h4>Total Revenue: $".number_format($result['0']['Total Revenue'])."</h4>";
    	}else{
    		$info .="<h4>Total Revenue: $0</h4>";
    	}
    	return $info;

	}
	function admin_function($company_id, $uid){
		$dbh = database();
		$stmt = $dbh->prepare('SELECT permission_id FROM company_permissions where company_id="'.$company_id.'" AND user_id="'.$uid.'";');
		$stmt->execute(); 
    	$result = $stmt->fetchall(PDO::FETCH_ASSOC);
    	if ($result['0']['permission_id']==='1' || $result['0']['permission_id']==='2'){
    		$info="<a href='dashboard.php'class='btn btn-primary btn-sm r-float'>Dashboard</a>
					<br class='clear'>
					<a href='admin.php?id=".$company_id."'class='btn btn-primary btn-sm r-float'>Admin</a>";
    		return $info;
    	}else{
			$info="<a href='dashboard.php'class='btn btn-primary btn-sm r-float'>Dashboard</a>";
    		return $info;
    	}
	}
	function admin_edit($company_id, $uid){
		$dbh = database();
		$stmt = $dbh->prepare('SELECT permission_id FROM company_permissions where company_id="'.$company_id.'" AND user_id="'.$uid.'";');
		$stmt->execute(); 
    	$result = $stmt->fetchall(PDO::FETCH_ASSOC);
    	if ($result['0']['permission_id']==='1' || $result['0']['permission_id']==='2'){
    		$info="<a href='editmetric.php?id=".$company_id."' class='btn btn-primary btn-sm r-float edit_btn'>Edit/Add</a>";
    		return $info;
    	}
	}

	function edit_users($company_id, $cid){
		
		$dbh = database();
		$stmt = $dbh->prepare('SELECT fname, lname, email, role, cp.id, cp.user_id FROM user u Left JOIN company_permissions cp ON cp.user_id =u.id LEFT JOIN company c ON c.id = cp.company_id LEFT JOIN permissions p ON p.id = cp.permission_id WHERE cp.company_id ='.$company_id.';');
		$stmt->execute(); 
    	$result = $stmt->fetchall(PDO::FETCH_ASSOC);
    	$info ="";
    	foreach ($result as $metric){
    		if($metric['user_id']===$cid){
    			$u_role = $metric['role'];
    			$info .= "<tr>";
    			$info .="<td><input type='hidden' name='id' id='id' value='".$metric['id']."'/><input type='hidden' name='user_id' id='user_id' value='".$metric['user_id']."'/><input type='text' name='fname' id='fname' value='".$metric['fname']."'/></td>";
	    		$info .="<td><input type='text' name='lname' id='lname' value='".$metric['lname']."'/></td>";
	    		$info .="<td><input type='text' name='email' id='email' value='".$metric['email']."'/></td>";
    			$info .="<td><select name='role' id='role'>";
    			$info .= get_roles($u_role);
    			$info .="</select>";
    			$info .="<td><input type='submit' class='btn btn-primary btn-sm'></input></td>";
    			$info .="</tr>";
    		}else{
	    		$info .= "<tr>";
	    		$info .="<td>".$metric['fname']."</td>";
	    		$info .="<td>".$metric['lname']."</td>";
	    		$info .="<td>".$metric['email']."</td>";
	    		$info .="<td>".$metric['role']."</td>";
				$info .="<td> <a href='admin.php?id=".$company_id."&cid=".$metric['user_id']."' type='button' class='btn btn-primary btn-sm'>Edit</a></td>";
				$info .="</tr>";
			}
    	}
    	return $info;
	}
	function get_roles($u_role){
		$dbh = database();
		$stmt = $dbh->prepare('SELECT id, role FROM permissions;');
		$stmt->execute(); 
    	$result = $stmt->fetchall(PDO::FETCH_ASSOC);
    	$info ="";
    	foreach ($result as $roles){
    		if($roles['role']==$u_role){
    			$info .= "<option selected='selected' value='".$roles['role']."'>".$roles['role']."</option>";
    			
    		}else{
    			$info .= "<option value='".$roles['id']."'>".$roles['role']."</option>";		
    		}
    	}
		return $info;
	}









