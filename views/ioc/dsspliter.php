<div id="myMap" style="position:relative;width:100%px;height:1000px;"></div>
<script type='text/javascript'>
    function GetMap() {
        var map = new Microsoft.Maps.Map('#myMap', {
            credentials: 'AvfTOCp6deFCiiaKwzdfi_Z10QhqZgpDDbKDXEb6_Wengs8XpdH1FqwoDWWQa1So',
            center: new Microsoft.Maps.Location(20.64157486, 105.9970703)
        });
        var url = '/ioc/laydsspliter';
            $.ajax({
                url: url,
                method: 'get',
                data: {
                },
                success:function(data) {
                    data = jQuery.parseJSON(data);
                    for (var i = data.length - 1; i >= 0; i--) {
                        //Add the pushpin to the map
                        var pin = new Microsoft.Maps.Pushpin(new Microsoft.Maps.Location(data[i].VIDO, data[i].KINHDO),
                         {title: data[i].TEN_KC, color: 'red',});
                        map.entities.push(pin);
                    }
                }
            });
    }
</script>
<script type='text/javascript' src='http://www.bing.com/api/maps/mapcontrol?callback=GetMap' async defer></script>