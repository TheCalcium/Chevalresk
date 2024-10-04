$(document).ready(function () {

    document.querySelectorAll(".panier-item-quantity").forEach( txtBox => {
        txtBox.addEventListener('keydown', e => {

            if (!isNaN(e.key) && txtBox.textContent.length >= 3) {
                e.preventDefault();
            }

            if (isNaN(e.key) && e.key !== 'Backspace' && e.key !== 'ArrowLeft' && e.key !=='ArrowRight') {
                e.preventDefault();
            }
        });

        txtBox.onblur = () => {

            if (txtBox.textContent.length < 1) {
                txtBox.textContent = "0";
            }

            let idItem = txtBox.getAttribute("idItem");
            let quantity = parseInt(txtBox.textContent);
            update(idItem, quantity);
        }
    });

    document.querySelectorAll(".panier-item-btn-add").forEach( btn => {
        let idItem = btn.getAttribute("idItem");
        let panier_quantity = document.querySelector("#panier-item-quantity-" + idItem);

        btn.addEventListener("click", () => {
            let quantity = parseInt(panier_quantity.textContent) 
            let new_quantity = (quantity < 100) ? quantity + 1 : 999;
            
            update(idItem, new_quantity);
            btn.setAttribute("quantity", new_quantity);
            panier_quantity.textContent = new_quantity;
        });
    });

    document.querySelectorAll(".panier-item-btn-sub").forEach( btn => {
        let idItem = btn.getAttribute("idItem");
        let panier_quantity = document.querySelector("#panier-item-quantity-" + idItem);

        btn.addEventListener("click", () => {
            let quantity = parseInt(panier_quantity.textContent)
            let new_quantity = quantity - 1;

            update(idItem, new_quantity);
            btn.setAttribute("quantity", new_quantity);
            panier_quantity.textContent = new_quantity;

            if (new_quantity < 1) {
                if (document.querySelectorAll(".panier-item").length == 1) {
                    document.querySelector(".panier-vide").classList.remove("hidden");
                    document.querySelector(".panier-error").classList.add("hidden");
                    document.querySelector(".panier-layout-pay").classList.add("hidden");
                }

                document.querySelector(".panier-item-" + idItem).remove();
            };
        });
    });

    function update(idItem, quantity) {
        let prix = parseInt(document.querySelector(".panier-item-prix-" + idItem).textContent);
        let dif = (prix * quantity) - parseInt(document.querySelector(".panier-item-total-" + idItem).textContent);
        let total = parseInt(document.querySelector("#panier-total").textContent);
        
        document.querySelector(".panier-item-info-quantity-" + idItem).textContent = quantity;
        document.querySelector(".panier-item-info-total-" + idItem).textContent = prix * quantity + "$";
        document.querySelector(".panier-item-total-" + idItem).textContent = prix * quantity + "$";
        document.querySelector("#panier-total").textContent = total + dif + "$";

        if (quantity < 1) {
            document.querySelector(".pay-content-" + idItem).remove();
            document.querySelector(".panier-item-" + idItem).remove();
        }

        $.ajax({
            url: 'panierUpdate.php',
            method: 'POST',
            data: {
                id: idItem,
                quantity: quantity,
            }
        });
    }
});