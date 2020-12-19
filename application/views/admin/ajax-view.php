<?php
if (isset($materials)) {
	if (!empty($materials)) {
		foreach ($materials as $key => $value) {
			if ($value->status == 0) {
				$status = '<a href="javascript:void(0)" id="' . $value->material_id . '" class="change-p-status text-danger" data-status="1" data-table="materials" data-key-id="material_id" data-id="' . $value->material_id . '">Inactive</a>';
			} else if ($value->status == 1) {
				$status = '<a href="javascript:void(0)" id="' . $value->material_id . '" class="change-p-status text-success" data-status="0" data-table="materials" data-key-id="material_id" data-id="' . $value->material_id . '">Active</a>';
			}
			$html .= '<tr>
						<td>' . ($key+1) . '</td>
                    	<td><span>' . $value->material_name . '</span></td>
                    	<td>' . $status . '</td>
						<td>
							<a class="edit_class" href="'.base_url("admin/material/edit/".$value->material_id).'"><img src="'.base_url("public/admin/").'img/pinkedit.png" alt="pinkedit"/></a>
                    		<a href="javascript:void(0)" class="btn btn-gray change-p-status" data-fnc="getOperationAreaList" data-status="3" data-f="del" data-table="materials" data-key-id="material_id" data-id="' . $value->material_id . '"><i class="fa fa-trash"></i></a>
                    	</td>
                    </tr>';
		}
	}else{
		$html .='<tr>
				<td colspan="4" align="center">
					No data found
				</td>
			</tr>';
	}
	echo $html;
} //end materials

if (isset($sizes)) {
	if (!empty($sizes)) {
		foreach ($sizes as $key => $value) {
			if ($value->status == 0) {
				$status = '<a href="javascript:void(0)" id="' . $value->attribute_size_id . '" class="change-p-status text-danger" data-status="1" data-table="attribute_sizes" data-key-id="attribute_size_id" data-id="' . $value->attribute_size_id . '">Inactive</a>';
			} else if ($value->status == 1) {
				$status = '<a href="javascript:void(0)" id="' . $value->attribute_size_id . '" class="change-p-status text-success" data-status="0" data-table="attribute_sizes" data-key-id="attribute_size_id" data-id="' . $value->attribute_size_id . '">Active</a>';
			}
			$html .= '<tr>
						<td>' . ($key+1) . '</td>
                    	<td><span>' . $value->size . '</span></td>
                    	<td><span>' . $value->product_type_name . '</span></td>
                    	<td>' . $status . '</td>
						<td>
							<a class="edit_class" href="'.base_url("admin/attribute-size/edit/".$value->attribute_size_id).'"><img src="'.base_url("public/admin/").'img/pinkedit.png" alt="pinkedit"/></a>
                    		<a href="javascript:void(0)" class="btn btn-gray change-p-status" data-fnc="getOperationAreaList" data-status="3" data-f="del" data-table="attribute_sizes" data-key-id="attribute_size_id" data-id="' . $value->attribute_size_id . '"><i class="fa fa-trash"></i></a>
                    	</td>
                    </tr>';
		}
	}else{
		$html .='<tr>
				<td colspan="5" align="center">
					No data found
				</td>
			</tr>';
	}
	echo $html;
} //end Attribute size

if (isset($styles)) {
	if (!empty($styles)) {
		foreach ($styles as $key => $value) {
			if ($value->status == 0) {
				$status = '<a href="javascript:void(0)" id="' . $value->attribute_style_id . '" class="change-p-status text-danger" data-status="1" data-table="attribute_styles" data-key-id="attribute_style_id" data-id="' . $value->attribute_style_id . '">Inactive</a>';
			} else if ($value->status == 1) {
				$status = '<a href="javascript:void(0)" id="' . $value->attribute_style_id . '" class="change-p-status text-success" data-status="0" data-table="attribute_styles" data-key-id="attribute_style_id" data-id="' . $value->attribute_style_id . '">Active</a>';
			}
			$html .= '<tr>
						<td>' . ($key+1) . '</td>
                    	<td><span>' . $value->style . '</span></td>
                    	<td>' . $status . '</td>
						<td>
							<a class="edit_class" href="'.base_url("admin/attribute-style/edit/".$value->attribute_style_id).'"><img src="'.base_url("public/admin/").'img/pinkedit.png" alt="pinkedit"/></a>
                    		<a href="javascript:void(0)" class="btn btn-gray change-p-status" data-fnc="getOperationAreaList" data-status="3" data-f="del" data-table="attribute_styles" data-key-id="attribute_style_id" data-id="' . $value->attribute_style_id . '"><i class="fa fa-trash"></i></a>
                    	</td>
                    </tr>';
		}
	}else{
		$html .='<tr>
				<td colspan="5" align="center">
					No data found
				</td>
			</tr>';
	}
	echo $html;
} //end Attribute Style

if (isset($products)) {
	if (!empty($products)) {
		foreach ($products as $key => $value) {
			if ($value->status == 0) {
				$status = '<a href="javascript:void(0)" id="' . $value->product_id . '" class="change-p-status text-danger" data-status="1" data-table="products" data-key-id="product_id" data-id="' . $value->product_id . '">Inactive</a>';
			} else if ($value->status == 1) {
				$status = '<a href="javascript:void(0)" id="' . $value->product_id . '" class="change-p-status text-success" data-status="0" data-table="products" data-key-id="product_id" data-id="' . $value->product_id . '">Active</a>';
			}
			if($value->product_image ==""){
				$value->product_image = base_url('uploads/no_image.png');
			}
			$html .= '<tr>
                    	<td><span>' . $value->product_name . '<p>'.$value->product_suk_id.'</p></span></td>
                    	<td>' . $value->size . '</td>
						<td>$'.round($value->price, 2).'</td>
						<td><img class="cat_img_table" src="' . $value->product_image . '" alt="cat1"/></td>
						<td>' . substr($value->description,0, 50) . '..</td>
                    	<td>' . $status . '</td>
						<td>
							<a class="edit_class" href="'.base_url("admin/product/edit/".$value->product_id).'"><img src="'.base_url("public/admin/").'img/pinkedit.png" alt="pinkedit"/></a>
                    		<a href="javascript:void(0)" class="btn btn-gray change-p-status" data-fnc="getOperationAreaList" data-status="3" data-f="del" data-table="products" data-key-id="product_id" data-id="' . $value->product_id . '"><i class="fa fa-trash"></i></a>
                    	</td>
                    </tr>';
		}
	}else{
		$html .='<tr>
				<td colspan="7" align="center">
					No data found
				</td>
			</tr>';
	}
	echo $html;
} //end Produces
if (isset($charges)) {
	if (!empty($charges)) {
		foreach ($charges as $key => $value) {
			if ($value->status == 0) {
				$status = '<a href="javascript:void(0)" id="' . $value->id . '" class="change-p-status text-danger" data-status="1" data-table="delivery_charges" data-key-id="id" data-id="' . $value->id . '">Inactive</a>';
			} else if ($value->status == 1) {
				$status = '<a href="javascript:void(0)" id="' . $value->id . '" class="change-p-status text-success" data-status="0" data-table="delivery_charges" data-key-id="id" data-id="' . $value->id . '">Active</a>';
			}
			$html .= '<tr>
						<td>' . ($key+1) . '</td>
						<td>' . $value->item_quantity . '</td>
                    	<td>' . round($value->amount, 2) . '</td>
                    	<td>' . $status . '</td>
						<td>
							<a class="edit_class" href="'.base_url("admin/charge/edit/".$value->id).'"><img src="'.base_url("public/admin/").'img/pinkedit.png" alt="pinkedit"/></a>
                    		<a href="javascript:void(0)" class="btn btn-gray change-p-status" data-fnc="getOperationAreaList" data-status="3" data-f="del" data-table="delivery_charges" data-key-id="id" data-id="' . $value->id . '"><i class="fa fa-trash"></i></a>
                    	</td>
                    </tr>';
		}
	}else{
		$html .='<tr>
				<td colspan="8" align="center">
					No data found
				</td>
			</tr>';
	}
	echo $html;
} //end Charge
