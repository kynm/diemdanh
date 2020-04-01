<H1>
   <?php echo $donvi->TEN_DONVI;?> 
</H1>
<?= $this->render('_table_data', [
    'data' => $data,
    'dongiamayno' => $dongiamayno,
]) ?>