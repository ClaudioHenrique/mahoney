var pluginsIndexController = {
    config: {
        
    },
    tmp: {
        
    }
};
$(document).ready(function(){
    $("[data-controller]").click(function(){
        var obj = $(this);
        obj.button('loading');
        switch($(this).data("controller")){
            case "migrate":
                var dataSend = {plugin: $(this).data("target")};
                $.getJSON("plugins/migrate", {data: dataSend}, function(data) {
                
                })
                .done(function(data){
                    if(data.status == "OK") {
                        obj.hide();
                    }
                })
                .always(function(){
                    obj.button('reset');
                });
                break;
            default:
                break;
        }
    });
});