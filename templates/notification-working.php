<style>
    .contents {
  background: yellow;
  color: rgba(0, 0, 0, .8);
  padding: 20px;
  margin:0;
}
.slide-up, .slide-down {
  overflow:hidden
}
.slide-up > div, .slide-down > div {
  margin-top: -25%;
  transition: margin-top 0.4s ease-in-out;
  position:absolute;
  width:100%;
  
}
.slide-down > div {            
  margin-top: 0;
  width:100%;
  position:absolute;
} 

.notification-bell {
    position: relative;
    right:0;
    margin-right:10px;
    display: inline-block;
    cursor: pointer;
}
        
.notification-bell .icon {
    font-size: 20px;
    color: #333;
    position: relative;
}
.notification-bell .badge {
    position: absolute;
    top: -8px;
    right: -8px;
    background-color: red;
    color: white;
    font-size: 9px;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
}
.btn{
    border:none;
    background-color:none
}

</style>
<div class="container">
    <div class="notification-bell">
    <button onclick="trigger()" class="btn">🔔</button>

    <div class="badge" id="notificationCount">12</div></div>
    </div>
  
    <div id="Slider" class="slide-up">
        <div>
        <p class="contents">
            Hello World Text
        </p>
        </div>
    </div>
</div>

<script src="/Javascript/sb-admin/notification-script.js"></script>