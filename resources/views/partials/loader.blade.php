<div id="loader" style="display: none;">
    <h1>Cooking in progress</h1>
    <div id="cooking">
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div id="area">
            <div id="sides">
                <div id="pan"></div>
                <div id="handle"></div>
            </div>
            <div id="pancake">
                <div id="pastry"></div>
            </div>
        </div>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css?family=Amatic+SC');
    #loader {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.8); /* Semi-transparent background */
        z-index: 9999; /* Ensures it stays above other elements */
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
    }

    #cooking {
        width: 150px;
        height: 150px;
        position: relative;
        overflow: hidden;
    }

    h1 {
        font-size: 2rem;
        color: #333;
        opacity: 0.75;
        animation: pulse 2.5s linear infinite;
        text-align: center;
        font-family: 'Amatic SC', cursive;
        margin-bottom: 20px;
    }

    #cooking #area {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 50%;
        height: 50%;
        background-color: transparent;
        transform-origin: 15% 60%;
        animation: flip 2.1s ease-in-out infinite;
    }

    #cooking #area #sides {
        position: absolute;
        width: 100%;
        height: 100%;
        transform-origin: 15% 60%;
        animation: switchSide 2.1s ease-in-out infinite;
    }

    #cooking #area #sides #handle {
        position: absolute;
        bottom: 18%;
        right: 80%;
        width: 35%;
        height: 20%;
        background-color: transparent;
        border-top: 1vh solid #333;
        border-left: 1vh solid transparent;
        border-radius: 100%;
        transform: rotate(20deg) rotateX(0deg) scale(1.3, 0.9);
    }

    #cooking #area #sides #pan {
        position: absolute;
        bottom: 20%;
        right: 30%;
        width: 50%;
        height: 8%;
        background-color: #333;
        border-radius: 0 0 1.4em 1.4em;
        transform-origin: -15% 0;
    }

    #cooking #area #pancake {
        position: absolute;
        top: 24%;
        width: 100%;
        height: 100%;
        transform: rotateX(85deg);
        animation: jump 2.1s ease-in-out infinite;
    }

    #cooking #area #pancake #pastry {
        position: absolute;
        bottom: 26%;
        right: 37%;
        width: 40%;
        height: 45%;
        background-color: #333;
        box-shadow: 0 0 3px 0 #333;
        border-radius: 100%;
        transform-origin: -20% 0;
        animation: fly 2.1s ease-in-out infinite;
    }

    #cooking .bubble {
        position: absolute;
        border-radius: 100%;
        box-shadow: 0 0 0.25vh #4d4d4d;
        opacity: 0;
    }

    #cooking .bubble:nth-child(1) {
        margin-top: 2.5vh;
        left: 58%;
        width: 2.5vh;
        height: 2.5vh;
        background-color: #454545;
        animation: bubble 2s cubic-bezier(0.53, 0.16, 0.39, 0.96) infinite;
    }

    #cooking .bubble:nth-child(2) {
        margin-top: 3vh;
        left: 52%;
        width: 2vh;
        height: 2vh;
        background-color: #3d3d3d;
        animation: bubble 2s ease-in-out 0.35s infinite;
    }

    #cooking .bubble:nth-child(3) {
        margin-top: 1.8vh;
        left: 50%;
        width: 1.5vh;
        height: 1.5vh;
        background-color: #333;
        animation: bubble 1.5s cubic-bezier(0.53, 0.16, 0.39, 0.96) 0.55s infinite;
    }

    #cooking .bubble:nth-child(4) {
        margin-top: 2.7vh;
        left: 56%;
        width: 1.2vh;
        height: 1.2vh;
        background-color: #2b2b2b;
        animation: bubble 1.8s cubic-bezier(0.53, 0.16, 0.39, 0.96) 0.55s infinite;
    }

    #cooking .bubble:nth-child(5) {
        margin-top: 2.7vh;
        left: 63%;
        width: 1.1vh;
        height: 1.1vh;
        background-color: #242424;
        animation: bubble 1.6s ease-in-out 1s infinite;
    }
</style>
