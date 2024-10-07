CKEDITOR.plugins.add('removeSandbox', {
    init: function(editor) {
        editor.on('contentDom', function() {
            editor.on('setData', function(event) {
                console.log('setData event fired');
                console.log('Original data:', event.data.dataValue);
                
                var data = event.data.dataValue;
                data = data.replace(/<iframe[^>]*sandbox[^>]*>/gi, function(match) {
                    return match.replace(/sandbox="[^"]*"/i, '');
                });
                
                console.log('Modified data:', data);
                event.data.dataValue = data;
            });

            editor.on('getData', function(event) {
                console.log('getData event fired');
                console.log('Original data:', event.data.dataValue);
                
                var data = event.data.dataValue;
                data = data.replace(/<iframe[^>]*sandbox[^>]*>/gi, function(match) {
                    return match.replace(/sandbox="[^"]*"/i, '');
                });
                
                console.log('Modified data:', data);
                event.data.dataValue = data;
            });
        });
    }
});
