
$("#btn-img").click(function() {
    let itemId= $("#ad_images div.form-group").length;     
    let elt= $("#ad_images").data("prototype").replace(/__name__/g, itemId);

    $("#ad_images").append(elt);
    handleDelete();    
});

function handleDelete(){
    $('button[data-action="delete"]').click( (e) => {
        let att=e.target.dataset.target;
        console.log(att);
            $(att).remove();
    });
}
handleDelete();  
deleteAd();

function deleteAd(){
    let delAdsBtn=document.querySelectorAll(".delAds");
    for (let i = 0; i < delAdsBtn.length; i++) {
        const element = delAdsBtn[i];
        element.addEventListener("click",function () {
            confirm("voulez vous supprimer l'annonce "+ element.getAttribute("dataTarget"));
        })
        console.log(element.getAttribute("dataTarget"));
    }
}