
<style type="text/css">
	body {
		font-family: 'Lato', sans-serif;
	}
	table{
		border-collapse: collapse;
		border-spacing: 1px;
		padding: 0;
		width: 100%;
		font-family: 'Lato', sans-serif;
	}
	.header-style{
		font-weight: bold;
		background: darkseagreen;
		text-align: center;
	}
	.header{
		margin: 20px 0px 0px 10px;
	    font-weight: bold;
	    font-size: 20px;
	}
  .align-left{
    text-align:left;
  }
  .align-right{
    text-align:right;
  }
  .align-center{
    text-align:center;
  }
	table tr td {
		border: 1px solid #ccc;
		padding: 5px;
	}
  </style>
    <div class="header">Loom Data Report</div>
    <table>
        <tr>
          <?php foreach ($loomData->columns as $column): ?>
            <td class="header-style"><?php echo $column->header; ?></td>
          <?php endforeach;?>
        </tr>
        <?php foreach ($loomData->loomData as $data): ?>
          <tr>
				   	<?php foreach ($loomData->columns as $column2): ?>
								 <td><?php if ($column2->field == "LoomDate"): $coloumn23 = $column2->field;
    											echo date("d-m-Y", strtotime($data->$coloumn23));?>
		                     <?php else:$coloumn23 = $column2->field;
    											echo $data->$coloumn23;?>
												 <?php endif;?></td>
						<?php endforeach;?>
          </tr>
        <?php endforeach;?>
    </table>