// Fonction pour afficher le modal
function FunctionReserv() {
    document.getElementById("reservationModal").style.display = "block";
}

// Fonction pour fermer le modal
function closeModal() {
    document.getElementById("reservationModal").style.display = "none";
}

// Fermer le modal si l'utilisateur clique en dehors de la boîte
window.onclick = function(event) {
    var modal = document.getElementById("reservationModal");
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
