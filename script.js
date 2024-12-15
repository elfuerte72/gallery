
function openModal(imageSrc) {
    var modal = document.getElementById("myModal");
    var modalImage = document.getElementById("modalImage");

    modal.style.display = "flex";
    modalImage.src = imageSrc;
}


function closeModal() {
    var modal = document.getElementById("myModal");
    modal.style.display = "none";
}


window.onclick = function(event) {
    var modal = document.getElementById("myModal");
    if (event.target == modal) {
        modal.style.display = "none";
    }
}


window.onload = function() {
    var modal = document.getElementById("myModal");
    modal.style.display = "none";
}
