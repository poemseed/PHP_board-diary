<!-- editor -->
<link href='./SynapEditorPackage/SynapEditor/synapeditor.min.css' rel='stylesheet' type='text/css'>
<script src='./SynapEditorPackage/SynapEditor/synapeditor.config.js'></script>
<script src='./SynapEditorPackage/SynapEditor/synapeditor.min.js'></script>
<!-- 특수기호/이모지 -->
<script src="./SynapEditorPackage/SynapEditor/plugins/characterPicker/characterPicker.min.js"></script>
<link rel="stylesheet" href="./SynapEditorPackage/SynapEditor/plugins/characterPicker/characterPicker.min.css">
<!-- 컬러아이콘 -->
<script src="./SynapEditorPackage/SynapEditor/plugins/icons/basicColorIcons.js"></script>

<script src="./SynapEditorPackage/SynapEditor/externals/SEDocModelParser/SEDocModelParser.min.js"></script>
<script src="./SynapEditorPackage/SynapEditor/externals/SEShapeManager/SEShapeManager.min.js"></script>

<script>
  function initEditor(){
    var se = new SynapEditor("synapEditor", synapEditorConfig);
  }
</script>