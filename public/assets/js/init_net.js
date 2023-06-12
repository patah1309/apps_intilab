
function updateOnlineStatus(){
    if(navigator.onLine){
        $('#status-connection').removeClass('text-danger');
        $('#status-connection').addClass('text-success');
    } else {
        $('#status-connection').removeClass('text-success');
        $('#status-connection').addClass('text-danger');
    }
    var textContent = `${navigator.onLine ? "Online" : "Offline"}`;
    $('#status-text').html(textContent)
}
document.addEventListener("DOMContentLoaded", function () {
    updateOnlineStatus();
    window.addEventListener('online',  updateOnlineStatus);
    window.addEventListener('offline', updateOnlineStatus);
});