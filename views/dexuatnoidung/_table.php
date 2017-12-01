<?php

use yii\helpers\Html;

?>

<table class="table table-responsive" id="tags-table">
    <thead>
        <th>Loại thiết bị</th>
        <th>Lần bảo dưỡng</th>
        <th>Chu kỳ bảo dưỡng</th>
        <th>Nội dung bảo dưỡng</th>
        <th class="text-center">Action</th>
    </thead>
    <tbody>
    <?php
    	Dexuatnoidung::find()->all();
    	foreach ($ID_LOAITB as $key => $value) {
    		# code...
    	}
    ?>
            <tr>

                <td></td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td></td>
                <td class="text-center">

                </td>
            </tr>
        @endforeach
    @else
        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
            <h1>Nothing to show</h1>
        </div>
    @endif
    </tbody>
</table>

