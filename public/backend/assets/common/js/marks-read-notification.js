
function sendMarkRequest(id = null) {
    return $.ajax("/student/mark-as-read", {
        method: 'POST',
        
    });
}
$(function() {
    
    $('#mark-all').click(function(e) {
        e.preventDefault();
        let request = sendMarkRequest();
        request.done(() => {
            
            location.reload();
        })
    });
});