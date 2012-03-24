<script>
    $(document).ready(function(){
        $("img#vid").click(function(){
            $("div#vid").html('<iframe width="848" height="379" src="http://www.youtube.com/embed/QH2-TGUlwu4?autoplay=1&html5=1" frameborder="0" allowfullscreen></iframe>');
        });
    });
</script>
<div id="vid">
    <img id="vid" src="<?=base_url();?>assets/images/vid.png" width="848" height="379" style="cursor: pointer;"/>
</div>