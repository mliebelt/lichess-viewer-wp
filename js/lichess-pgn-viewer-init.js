document.addEventListener("DOMContentLoaded", function () {
  console.log("DOM Content Loaded");
  console.log("LichessPgnViewer:", window.LichessPgnViewer);
  console.log("lpgnvConfigs:", window.lpgnvConfigs);

  if (window.lpgnvConfigs && window.LichessPgnViewer) {
    const viewer = window.LichessPgnViewer.default || window.LichessPgnViewer;
    window.lpgnvConfigs.forEach(function (item) {
      console.log("Initializing viewer for", item.id);
      viewer(document.getElementById(item.id), item.config);
    });
  } else {
    console.error("LichessPgnViewer or configs not found");
    if (!window.LichessPgnViewer)
      console.error("LichessPgnViewer is not defined");
    if (!window.lpgnvConfigs) console.error("lpgnvConfigs is not defined");
  }
});
