require.config({
    baseUrl: '/AppShopService/Public/Js/lib/',
    paths:{
        domReady: 'domReady',
        avalon: 'avalon.modern.shim',
    }
});
define(['domReady', 'avalon'], function(domReady, avalon){
    domReady(function(){
        var $$id;
        //main vm
        var vmMain = avalon.define({
            $id: 'main',
            loaded: true,
            cTab: 0,   //0 list  add 1 check 2
            switchTab: function(id){
                vmMain['cTab'] = id;
            }
        });
        avalon.scan();
    });
});