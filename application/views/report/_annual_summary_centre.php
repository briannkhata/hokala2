<?php $this->load->view("includes/header.php"); ?>
<?php $this->load->view("includes/menu.php"); ?>
<!--start main wrapper-->
<main class="main-wrapper">
   <div class="main-content">
      <h6 class="mb-0 text-uppercase"><?= $page_title ?></h6>
      <hr>
   </div>
   <div class="card">
   <div class="card-body">
      <div class="table-responsive">
         <table id="example" class="table table-striped table-bordered" style="width:100%">
         
           
            <?php
            echo '<tr>';
            echo '<th><th>';
            //count categories
            $top_header_cat_id_array = array();
            foreach ($cats as $row) {
                //make dynamic columns from rows using table header
                //echo'<th>'.strtoupper($row['category_name']).'</th>';
                echo '<th>' . $row['category_name'] . '</th>';
                //add item(catID) to cat_array
                $top_header_cat_id_array[] = $row['category_id'];
            }
            echo '<th>TOTAL</th>';
            echo '</tr>';
            //print rows
            //sum asset cost price by category
            echo '<tr>
                       <td></td>
                        <td>Cost as at ' . date('d-M-y', strtotime($start_date)) . '</td>';
            $cost_group_total = 0; // sum of all cost groups 
            $cost_cat_id_array = array();
            $cost_actual_value_array = array();
            foreach ($costs as $row_cost) {
                //add item(catID) to cost_array
                $cost_cat_id_array[] = $row_cost['category_id'];
                //$cost_group_total += $row_cost['asset_costprice'];
            }
            //print blank td when cost-cat-id nothing
            $cost_maped_array = array_map(function ($i) use ($cost_cat_id_array) {
                return in_array($i, $cost_cat_id_array) ? $i : 0;
            }, $top_header_cat_id_array);
            //loop thru newly created array
            foreach ($cost_maped_array as $costID) {
                //get total sum of assets by category
                if ($costID > 0) {
                    //check if there is disposed asset for a particular category
                    //before selected quarter
                    $count_prev_quarter_disposed_assets = $this->M_report->count_prev_quarter_disposed_assets($start_date, $costID);
                    if ($count_prev_quarter_disposed_assets >= 1) {
                        //Yes before current quarter there is disposed asset
                        $query_str = "SELECT SUM(cost_price) AS total FROM tbl_asset_depreciations d INNER JOIN tbl_asset_register a ON a.asset_id = d.asset_ID WHERE  a.dispose_state = 'no' AND a.asset_purchasedDate < '" . $start_date . "' AND d.fy_start_month BETWEEN '" . $start_date . "' AND '" . $march_end . "' AND d.category_id = $costID AND a.centre_id = $centre_id";
                    } else {
                        //No there is No asset disposed
                        $query_str = "SELECT SUM(cost_price) AS total FROM tbl_asset_depreciations d INNER JOIN tbl_asset_register a ON a.asset_id = d.asset_ID WHERE d.category_id = $costID AND d.fy_start_month BETWEEN '" . $start_date . "' AND '" . $march_end . "' AND a.asset_purchasedDate < '" . $start_date . "' AND a.centre_id = $centre_id";
                    }
                    //}
                    $query = $this->db->query($query_str);
                    $record = $query->row();
                    if ($record->total === NULL) {
                        $cost_cat_total_sum = 0;
                        $cost_group_total += 0;
                    } else {
                        $cost_cat_total_sum = $record->total;
                        $cost_group_total += $record->total;
                    }
                    $cost_actual_value_array[] = $cost_cat_total_sum;
                    //get sum total of the catID
                    echo '<td>' . number_format($cost_cat_total_sum, 2) . '</td>';
                } else {
                    $cost_actual_value_array[] = 0;
                    //print zero$disposalID
                    echo "<td>0.00</td>";
                }
            }
            echo '<td>' . number_format($cost_group_total, 2) . '</td>';
            echo '</tr>';
            //sum asset addition
            echo '<tr>
            <td></td>
            <td>Additions</td>';
            $additions_group_total = 0; // sum of all addition groups 
            $additions_cat_id_array = array();
            $addition_actual_value_array = array();
            foreach ($additions as $row_additions) {
                //add item(catID) to additions_array
                $additions_cat_id_array[] = $row_additions['category_id'];
                //$additions_group_total += $row_additions['asset_costprice'];
            }
            //print blank td when cost-cat-id nothing
            $additions_maped_array = array_map(function ($i) use ($additions_cat_id_array) {
                return in_array($i, $additions_cat_id_array) ? $i : 0;
            }, $top_header_cat_id_array);
            //loop thru newly created array
            foreach ($additions_maped_array as $addID) {
                //get total sum of assets by category
                if ($addID > 0) {
                    //sum 1st,2nd,3rd and 4th additional assets
                   $first_quarter_additional_assets = $this->M_report->get_quarter_additional_assets_centre($selected_year.'-01-01',$selected_year.'-03-31',$addID,$centre_id);
                   //var_dump($first_quarter_additional_assets);
                   $second_quarter_additional_assets = $this->M_report->get_quarter_additional_assets_centre($selected_year.'-04-01',$selected_year.'-06-30',$addID,$centre_id);
                  //var_dump($second_quarter_additional_assets);
                  $count_second_quarter_duplicate = $this->M_report->count_asset_quarter_dep_duplicate_centre($selected_year.'-04-01',$selected_year.'-06-30',$addID,$centre_id);
                  //echo $count_second_quarter_duplicate."<br>";
                  if($count_second_quarter_duplicate > 0){
                   $second_quarter_newones = $second_quarter_additional_assets / 2;
                  }else{
                   $second_quarter_newones = $second_quarter_additional_assets;
                  }
                  //
                  $third_quarter_additional_assets = $this->M_report->get_quarter_additional_assets_centre($selected_year.'-07-01',$selected_year.'-09-30',$addID,$centre_id,$centre_id);
                  //var_dump($third_quarter_additional_assets);
                  $count_third_quarter_duplicate = $this->M_report->count_asset_quarter_dep_duplicate_centre($selected_year.'-07-01',$selected_year.'-09-30',$addID,$centre_id,$centre_id);
                  //echo $count_third_quarter_duplicate."<br>";
                  if($count_third_quarter_duplicate > 0){
                   $third_quarter_newones = $third_quarter_additional_assets / 3;
                  }else{
                   $third_quarter_newones = $third_quarter_additional_assets;
                  }
                  //
                  $fourth_quarter_additional_assets = $this->M_report->get_quarter_additional_assets_centre($selected_year.'-10-01',$selected_year.'-12-31',$addID,$centre_id);
                  //var_dump($fourth_quarter_additional_assets);
                  $count_fourth_quarter_duplicate = $this->M_report->count_asset_quarter_dep_duplicate_centre($selected_year.'-10-01',$selected_year.'-12-31',$addID,$centre_id);
                  //echo $count_third_quarter_duplicate."<br>";
                  if($count_fourth_quarter_duplicate > 0){
                   $fourth_quarter_newones = $fourth_quarter_additional_assets / 4;
                  }else{
                   $fourth_quarter_newones = $fourth_quarter_additional_assets;
                  }
                  //sum all quarter additionalassets
                  //var_dump($first_quarter_additional_assets);
                  $sum_all_quarter_additional_assets = $first_quarter_additional_assets + $second_quarter_newones + $third_quarter_newones + $fourth_quarter_newones;

                        $additions_cat_total_sum = $sum_all_quarter_additional_assets;
                        $additions_group_total += $sum_all_quarter_additional_assets;
                    //}
                    $addition_actual_value_array[] = $additions_cat_total_sum;
                    //get sum total of the catID
                    echo '<td>' . number_format($additions_cat_total_sum, 2) . '</td>';
                } else {
                    $addition_actual_value_array[] = 0;
                    $additions_group_total += 0;
                    //print zero
                    echo "<td>0.00</td>";
                }
            }
            echo '<td>' . number_format($additions_group_total, 2) . '</td>';
            echo '</tr>';
            //Revaluation
            echo '<tr>
                  <td></td>
                  <td>Valuation</td>';
            $valuation_group_total = 0; // sum of all valuation groups 
            $valuation_cat_id_array = array();
            $valuation_actual_value_array = array();
            foreach ($valuations as $row_valuation) {
                //add item(catID) to valuation_array
                $valuation_cat_id_array[] = $row_valuation['category_id'];
                //$valuation_group_total += $row_valuation['asset_costprice'];
            }
            //print blank td when cost-cat-id nothing
            $valuation_maped_array = array_map(function ($i) use ($valuation_cat_id_array) {
                return in_array($i, $valuation_cat_id_array) ? $i : 0;
            }, $top_header_cat_id_array);
            //loop thru newly created array
            foreach ($valuation_maped_array as $valID) {
                //get total sum of assets by category
                if ($valID > 0) {
                    $valuation_cat_total_sum = $this->db->select_sum('r.difference')->from('tbl_asset_register a')->join('tbl_revaluation r', 'a.asset_id = r.asset_id')->where(array('a.category_id' => $valID, 'r.reval_date >=' => $start_date, 'r.reval_date <=' => $end_date,'a.centre_id' => $centre_id, 'a.asset_status =' => 'active'))->group_by('a.category_id')->get()->row()->difference;
                    $valuation_actual_value_array[] = $valuation_cat_total_sum;
                    $valuation_group_total += $valuation_cat_total_sum;
                    //get sum total of the catID
                    echo '<td>' . number_format($valuation_cat_total_sum, 2) . '</td>';
                } else {
                    $valuation_actual_value_array[] = 0;
                    $valuation_group_total += 0;
                    //print zero
                    echo "<td>0.00</td>";
                }
            }
            echo '<td>' . number_format($valuation_group_total, 2) . '</td>';
            echo '</tr>';
            //cost of disposed
            echo '<tr>
                        <td></td>
                             <td>Disposal</td>';
            $disposals_group_total = 0; // sum of all disposal groups 
            $disposals_cat_id_array = array();
            $disposal_actual_value_array = array();
            $disposal_actual_value_total = 0;
            foreach ($disposals as $row_disposals) {
                //add item(catID) to disposals_array
                $disposals_cat_id_array[] = $row_disposals['category_id'];
                //$disposals_group_total += $row_disposals['asset_costprice'];
            }
            //print blank td when cost-cat-id nothing
            $disposals_maped_array = array_map(function ($i) use ($disposals_cat_id_array) {
                return in_array($i, $disposals_cat_id_array) ? $i : 0;
            }, $top_header_cat_id_array);
            //loop thru newly created array
            foreach ($disposals_maped_array as $disposalID) {
                //get total sum of assets by category
                if ($disposalID > 0) {
                    $dis_str = "SELECT a.asset_id,SUM(d.cost_price) AS total,a.dispose_state,d.asset_ID,a.dispose_approved_date FROM tbl_asset_register a INNER JOIN tbl_asset_depreciations d ON a.asset_id = d.asset_ID  WHERE a.dispose_state ='disposed' AND d.fy_start_month BETWEEN '" . $start_date . "' AND '" . $march_end . "' AND a.dispose_approved_date BETWEEN '" . $start_date . "' AND '" . $end_date . "' AND d.category_id = $disposalID AND a.centre_id = $centre_id";
                    $query = $this->db->query($dis_str);
                    $record = $query->row();
                    $disposals_cat_total_sum = $record->total;
                    $disposal_actual_value_array[] = $disposals_cat_total_sum;
                    $disposals_group_total += $disposals_cat_total_sum;
                    //get sum total of the catID
                    echo '<td>' . number_format($disposals_cat_total_sum, 2) . '</td>';
                } else {
                    $disposal_actual_value_array[] = 0;
                    $disposals_group_total += 0;
                    //print zero
                    echo "<td>0.00</td>";
                }
            }
            echo '<td>' . number_format($disposals_group_total, 2) . '</td>';
            echo '</tr>';
            echo '<tr>
                 <td></td>
                 <th>Value as at ' . date('d-M-y', strtotime($end_date)) . '</th>';
            //cost + addition + valuation difference
            $cost_plus_addition_array = array();
            $value_as_end_of_quater = array();
            $costvalue_as_end_of_quarter = array();
            foreach ($cost_actual_value_array as $key => $value) {
                $cost_plus_addition_array[$key] = $value + ($addition_actual_value_array[$key] ?? 0) + ($valuation_actual_value_array[$key] ?? 0);
            }
            //cost_plus_addition - disposal_actual_value_array
            foreach ($cost_plus_addition_array as $key => $value) {
                $value_as_end_of_quater[$key] = $value - ($disposal_actual_value_array[$key] ?? 0);
                $value_as = $value_as_end_of_quater[$key];
                echo '<td>' . number_format($value_as, 2) . '</td>';
                //sum array after subtraction to give us total
                $costvalue_as_end_of_quarter[] = $value_as_end_of_quater[$key];
            }
            //print_r($costvalue_as_end_of_quarter); Total
            $sum_value_as_start_of_quarter_items = array_sum($costvalue_as_end_of_quarter);
            echo '<td>' . number_format($sum_value_as_start_of_quarter_items, 2) . '</td>';
            echo '</tr>';
            //Depreciation empty row 
            echo '<tr>
                        <td></td>
                             <th>Depreciation</th>';
            //blank row
            foreach ($cats as $row) {
                echo '<td></td>';
            }
            echo '<td></td>';
            echo '</tr>';
            //Depreciation value as of
            echo '<tr>
                        <td></td>
                        <td>As of ' . date('d-M-y', strtotime($start_date)) . '</td>';
            $accum_deps_group_total = 0; // sum of all accum_dep group 
            $accum_deps_cat_id_array = array();
            $accum_dep_actual_value = array();
            foreach ($accum_deps as $row_accum_deps) {
                //add item(catID) to accum_deps_array
                $accum_deps_cat_id_array[] = $row_accum_deps['category_id'];
            }
            //print blank td when cat-id nothing
            $accum_deps_maped_array = array_map(function ($i) use ($accum_deps_cat_id_array) {
                return in_array($i, $accum_deps_cat_id_array) ? $i : 0;
            }, $top_header_cat_id_array);
            //loop thru newly created array
            foreach ($accum_deps_maped_array as $accum_depre_id) {
                //get total sum of assets by category
                if ($accum_depre_id > 0) {
                    //check if there is disposed asset for a particular category
                    //before selected quarter
                    $count_d_assets = $this->M_report->count_prev_quarter_disposed_assets($start_date, $accum_depre_id);
                    //echo $count_d_assets;
                    if ($count_d_assets >= 1) {
                        //Yes before current quarter there is disposed asset
                        $dep_query = "SELECT SUM(d.quarter_dep) AS total FROM tbl_asset_depreciations d INNER JOIN tbl_asset_register a ON a.asset_id = d.asset_ID WHERE  a.dispose_state = 'no' AND d.fy_start_month < '" . $start_date . "' AND d.category_id = $accum_depre_id AND a.centre_id = $centre_id AND d.quarter_reval_state = 1";
                    } else {
                        //No there is No asset disposed
                        $dep_query = "SELECT SUM(d.quarter_dep) AS total FROM tbl_asset_depreciations d INNER JOIN tbl_asset_register a ON a.asset_id = d.asset_ID WHERE d.fy_start_month < '" . $start_date . "' AND d.category_id = $accum_depre_id AND a.centre_id = $centre_id AND d.quarter_reval_state = 1";
                    }
                    //}
                    //sum all dep from prev years
                    //$dep_query = "SELECT SUM(quarter_dep) AS total FROM tbl_asset_depreciations d INNER JOIN tbl_asset_register a ON a.asset_id = d.asset_ID WHERE a.asset_status = 'active' AND d.fy_start_month < '".$start_date."' AND d.category_id = $accum_depre_id";
                    $query = $this->db->query($dep_query);
                    $dep_result = $query->row();
                    $accum_deps_cat_total_sum = $dep_result->total;
                    //add to total
                    $accum_dep_actual_value[] = $accum_deps_cat_total_sum;
                    $accum_deps_group_total += $accum_deps_cat_total_sum;
                    echo '<td>' . number_format($accum_deps_cat_total_sum, 2) . '</td>';
                    //echo '<td>'.print_r($accum_deps_cat_total_sum).'</td>';
                    //echo $accum_deps_cat_total_sum['0']->quorter_total;
                } else {
                    $accum_dep_actual_value[] = 0;
                    //print zero
                    echo "<td>0.00</td>";
                }
            }
            echo '<td>' . number_format($accum_deps_group_total, 2) . '</td>';
            echo '</tr>';
            //charge for the Year
            echo '<tr>
                    <td></td>
                         <td>Charge for the Year</td>';
            $charge_group_total = 0; // sum of all accum_dep groups 
            $charge_cat_id_array = array();
            $charge_actual_value = array();
            foreach ($charges as $row_charge) {
                //add item(catID) to charge_array
                $charge_cat_id_array[] = $row_charge['category_id'];
                //$charge_group_total += $row_charge['quarter_dep'];
            }
            //print blank td when cat-id nothing
            $charge_maped_array = array_map(function ($i) use ($charge_cat_id_array) {
                return in_array($i, $charge_cat_id_array) ? $i : 0;
            }, $top_header_cat_id_array);
            //loop thru newly created array
            foreach ($charge_maped_array as $chargeID) {
                //get total sum of assets by category
                if ($chargeID > 0) {
                    //exclude charge(dep) of disposed asset
                    //$count_quarter_disposal = $this->M_report->count_quarter_disposed_assets($chargeID, $end_date);
                    //if ($count_quarter_disposal >= 1) {
                        //asset has been disposed in this quarter
                        //$charge_str = "SELECT SUM(d.quarter_dep) AS total FROM tbl_asset_depreciations d INNER JOIN tbl_asset_register a ON a.asset_id = d.asset_ID WHERE a.dispose_state = 'no' AND d.fy_start_month BETWEEN '$start_date' AND '$end_date' AND d.category_id = $chargeID AND a.centre_id = $centre_id";
                    //} else {
                        //No asset has been disposed in this quarter
                        $charge_str = "SELECT SUM(d.quarter_dep) AS total FROM tbl_asset_depreciations d INNER JOIN tbl_asset_register a ON a.asset_id = d.asset_ID WHERE d.fy_start_month BETWEEN '$start_date' AND '$end_date' AND d.category_id = $chargeID AND a.centre_id = $centre_id";
                    //}
                    $query = $this->db->query($charge_str);
                    $record = $query->row();
                    $charge_cat_total_sum = $record->total;
                    $charge_actual_value[] = $charge_cat_total_sum;
                    //total
                    $charge_group_total += $charge_cat_total_sum;
                    //get sum total of the catID
                    echo '<td>' . number_format($charge_cat_total_sum, 2) . '</td>';
                } else {
                    $charge_actual_value[] = 0;
                    //print zero
                    echo "<td>0.00</td>";
                }
            }
            echo '<td>' . number_format($charge_group_total, 2) . '</td>';
            echo '</tr>';
           //Valuation
           echo '<tr>
           <td></td>
                <td>Valuation</td>';
   $reval_group_total = 0; // sum of all accum_dep groups 
   $reval_cat_id_array = array();
   $reval_actual_value = array();
   foreach ($accum_revalued as $row_reval) {
       //add item(catID) to charge_array
       $reval_cat_id_array[] = $row_reval['cat_id'];
       //$reval_group_total += $row_reval['quarter_dep'];
   }
   //print blank td when cat-id nothing
   $reval_maped_array = array_map(function ($i) use ($reval_cat_id_array) {
       return in_array($i, $reval_cat_id_array) ? $i : 0;
   }, $top_header_cat_id_array);
   //loop thru newly created array
   foreach ($reval_maped_array as $revalID) {
       //get total sum of assets by category
       if ($revalID > 0) {
           //exclude charge(dep) of disposed asset
               //No asset has been disposed in this quarter
           //$reval_accum_dep = $this->db->select_sum('r.cur_accum_dep')->from('tbl_asset_register a')->join('tbl_revaluation r', 'a.asset_id = r.asset_id')->where(array('a.category_id' => $revalID, 'r.reval_date >=' => $start_date, 'r.reval_date <=' => $end_date, 'a.centre_id' => $centre_id,'a.asset_status =' => 'active'))->group_by('a.category_id')->get()->row()->cur_accum_dep;
           $reval_str = "SELECT SUM(r.cur_accum_dep) AS total FROM tbl_asset_register a INNER JOIN tbl_revaluation r ON  a.asset_id = r.asset_id WHERE a.asset_status = 'active' AND a.centre_id = $centre_id AND r.reval_date BETWEEN '$start_date' AND '$end_date' AND cat_id = $revalID ";
           $query = $this->db->query($reval_str);
           $record = $query->row();
           $reval_cat_total_sum = $record->total;
           $reval_actual_value[] = $reval_cat_total_sum;
           //total
           $reval_group_total += $reval_cat_total_sum;
           //get sum total of the catID
           echo '<td>' . number_format($reval_cat_total_sum, 2) . '</td>';
       } else {
           $reval_actual_value[] = 0;
           //print zero
           echo "<td>0.00</td>";
       }
   }
   echo '<td>' . number_format($reval_group_total, 2) . '</td>';
   echo '</tr>';
            //Disposal
            echo '<tr>
                <td></td>
                     <td>Disposal</td>';
            $accum_disposals_group_total = 0; // sum of all disposal groups 
            $accum_disposals_cat_id_array = array();
            $accum_disposed_actual_value = array();
            //var_dump($accum_disposals);
            foreach ($accum_disposals as $row_accum_disposals) {
                //add item(catID) to accum_disposals_array
                $accum_disposals_cat_id_array[] = $row_accum_disposals['category_id'];
            }
            //print blank td when cat-id nothing
            $accum_disposals_maped_array = array_map(function ($i) use ($accum_disposals_cat_id_array) {
                return in_array($i, $accum_disposals_cat_id_array) ? $i : 0;
            }, $top_header_cat_id_array);
            //loop thru newly created array
            foreach ($accum_disposals_maped_array as $dispoID) {
                //get total sum of assets by category
                if ($dispoID > 0) {
                    //sum accumulated depreciation of disposed asset (previous quarters excluding current)
                    $disp_str = "SELECT SUM(d.quarter_dep) AS total FROM tbl_asset_register a INNER JOIN tbl_asset_depreciations d ON a.asset_id = d.asset_ID WHERE a.dispose_state ='disposed' AND d.fy_start_month < '" . $end_date . "' AND a.dispose_approved_date BETWEEN '" . $start_date . "' AND '" . $end_date . "' AND d.category_id = $dispoID AND a.centre_id = $centre_id";
                    $query = $this->db->query($disp_str);
                    $record = $query->row();
                    $accum_disposals_cat_total_sum = $record->total;
                    $accum_disposed_actual_value[] = $accum_disposals_cat_total_sum;
                    //total
                    $accum_disposals_group_total += $accum_disposals_cat_total_sum;
                    //get sum total of the catID
                    echo '<td>' . number_format($record->total, 2) . '</td>';
                } else {
                    $accum_disposed_actual_value[] = 0;
                    //print zero
                    echo "<td>0.00</td>";
                }
            }
            echo '<td>' . number_format($accum_disposals_group_total, 2) . '</td>';
            echo '</tr>';
            //value as last day of quarter
            echo '<tr>
            <td></td>
                 <th>As at ' . date('d-M-y', strtotime($end_date)) . '</th>';
            //acum_dep_broght_forward + current_acum_dep(charge) - acum_dep_disposed_asset
            $dep_plus_charge_array = array();
            $dep_value_as_end_of_quater = array();
            $depvalue_as_end_of_quarter = array();
            foreach ($accum_dep_actual_value as $key => $value) {
                $dep_plus_charge_array[$key] = $value + ($charge_actual_value[$key] ?? 0);
            }
            //acum_dep_broght_forward + current_acum_dep(charge) - acum_dep_disposed_asset
            foreach ($dep_plus_charge_array as $key => $value) {
                $dep_value_as_end_of_quater[$key] = ($value - ($reval_actual_value[$key] ?? 0)) - ($accum_disposed_actual_value[$key] ?? 0);
                $value_c = $dep_value_as_end_of_quater[$key];
                echo '<td>' . number_format($value_c, 2) . '</td>';
                //sum array after subtraction to give us total
                $depvalue_as_end_of_quarter[] = $dep_value_as_end_of_quater[$key];
            }
            //print_r($costvalue_as_end_of_quarter); Total
            $sum_depvalue_as_end_of_quarter = array_sum($depvalue_as_end_of_quarter);
            echo '<td>' . number_format($sum_depvalue_as_end_of_quarter, 2) . '</td>';
            echo '</tr>';
            //Net book value
            echo '<tr>
            <td></td>
                 <th>Netbook Value</th>';
            //Netbook value costvalue_as_end_of_quarter - depvalue_as_end_of_quarter 
            $float_costvalue_as_end_of_quarter = array_map('floatval', $costvalue_as_end_of_quarter);
            $float_depvalue_as_end_of_quarter = array_map('floatval', $depvalue_as_end_of_quarter);
            $sub_results = array();
            $total_nbv = array();
            foreach ($float_costvalue_as_end_of_quarter as $key => $value) {
                $sub_results[$key] = $value - ($float_depvalue_as_end_of_quarter[$key] ?? 0);
                $echo_va = $sub_results[$key];
                echo '<td>' . number_format($echo_va, 2) . '</td>';
                //sum array after subtraction to give us total
                $total_nbv[] = $sub_results[$key];
            }
            $sum_total_nbv = array_sum($total_nbv);
            echo '<td>' . number_format($sum_total_nbv, 2) . '</td>';
            echo '</tr>';
            ?>
        </table>
        <button class="btn btn-primary export-btn"><i class="fa fa-file-excel-o"></i> Export to Excel</button>
        </table>
         <button class="btn btn-primary export-btn"><i class="fa fa-file-excel-o"></i> Export to Excel</button>
         </div>
   </div>
</main>
<!--end main wrapper-->
<?php $this->load->view("includes/footer.php"); ?>
        <script>
  $(document).ready(function(){
    $(".export-btn").click(function(){
        $("#AnnualReport").tableHTMLExport({
            type:'csv',
            filename:'<?php echo $this->M_report->get_asset_centre_name($centre_id)." ". $posted_year." FA Report" ?>.csv',
            });
    });
  
  });
  </script>
