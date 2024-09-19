<div class="toaster-box cursor-pointer fixed top-5 left-5 hidden z-20" id="toaster_div">
    <div class="flex items-center space-x-3 p-4 rounded-lg shadow-lg" id="toaster_wrapper">
        <span class="iconwrap">
            <img id="toaster_img" src="" alt="icon-image" class="w-8 h-8">
        </span>
        <span class="info flex-grow-1">
            <span class="info-description text-gray-800" id="toaster_description"></span>
        </span>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        Toaster.handleToaster();
    });

    const Toaster = {
        handleToaster: function (timeout = 5000) {
            let toasterMessage = "{{ session('successToaster') ?: session('errorToaster') ?: session('infoToaster') }}";
            let toasterType = '';

            if ("{{ session('successToaster') }}") {
                toasterType = 'successToaster';
            } else if ("{{ session('errorToaster') }}") {
                toasterType = 'errorToaster';
            } else if ("{{ session('infoToaster') }}") {
                toasterType = 'infoToaster';
            }

            if (toasterMessage && toasterType) {
                let imgSrc = '';
                let bgClass = '';
                switch (toasterType) {
                    case 'successToaster':
                        imgSrc = 'https://img.icons8.com/color/48/000000/checked--v1.png';
                        bgClass = 'bg-green-100 border border-green-400 text-green-800';
                        break;
                    case 'errorToaster':
                        imgSrc = 'https://img.icons8.com/color/48/000000/error--v1.png';
                        bgClass = 'bg-red-100 border border-red-400 text-red-800';
                        break;
                    case 'infoToaster':
                        imgSrc = 'https://img.icons8.com/color/48/000000/info--v1.png';
                        bgClass = 'bg-blue-100 border border-blue-400 text-blue-800';
                        break;
                }

                document.getElementById("toaster_img").src = imgSrc;
                document.getElementById("toaster_description").textContent = toasterMessage;
                document.getElementById("toaster_wrapper").className = `flex items-center space-x-3 p-4 rounded-lg shadow-lg ${bgClass}`;
                document.getElementById("toaster_div").classList.remove("hidden");

                setTimeout(function () {
                    document.getElementById("toaster_div").classList.add("hidden");
                }, timeout);
            }
        }
    }
</script>
