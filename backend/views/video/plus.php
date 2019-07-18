<?php
echo "<div style='overflow: auto;max-height: 300px;'><table class=\"table table-bordered table-condensed table-hover small kv-table\" >
<tr>
<th>场所名称</th>
<th>省</th>
<th>市</th>
<th>县/区</th>
<th>行业</th>
<th>详细地址</th>
<th>描述</th>
</tr>";
foreach ($model as $value){


    echo "<tr><td>$value->name</td>
          <td>".\backend\models\Area::getName($value->province)."</td>
          <td>".\backend\models\Area::getName($value->city)."</td>
          <td>".\backend\models\Area::getName($value->area)."</td>
          <td>".\backend\models\Industry::getName($value->industry)."</td>
          <td>".$value->address."</td>
          <td> $value->describtion</td></tr>";
}
echo "</table></div>";
?>
