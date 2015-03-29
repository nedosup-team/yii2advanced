jQuery(function($){
    var leftPart=$('.left-part').find('ul');
    var programFilter=$('.program-filter').find('select');
    var projectFilter=$('.project-filter').find('select');
    var typeFilter=$('.type-filter').find('select');

    $('.filter-program').select2();

    $.getJSON("/projects", function(data){
        if($('#map').length!=0){

            //GOOGLE MAP INITIALIZATION and  GEOLOCATION
            var mapOptions = {
                zoom: 6
            };
            var map = new google.maps.Map(document.getElementById('map'),mapOptions);
            var infowindow;

            if(navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var pos = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

                infowindow = new google.maps.InfoWindow({
                    map: map,
                    position: pos,
                    content: 'Ваше местоположение'
                });

                map.setCenter(pos);
            }, function() {
                handleNoGeolocation(true);
            });
            } else {
                handleNoGeolocation(false);
            }

            function handleNoGeolocation(errorFlag) {
              if (errorFlag) {
                var content = 'Ошибка: не удалось определить местоположение.';
              } else {
                var content = 'Ошибка: Ваш браузер не поддерживает геолокацию.';
              }

              var options = {
                map: map,
                position: new google.maps.LatLng(59.91273, 10.74609),
                zoom:2,
                content: content,
                mapTypeId:google.maps.MapTypeId.ROADMAP
              };

              infowindow = new google.maps.InfoWindow(options);
              map.setCenter(options.position);
            }




            //MARKERS ON MAP
            var markers = [];
            for(var i=0;i<data.length;i++){
                var x_cord = data[i].lat;
                var y_cord = data[i].lng;
                var project = data[i].title;
                var myLatLng = new google.maps.LatLng(x_cord, y_cord);
                var marker=new google.maps.Marker({
                        position: myLatLng,
                        title: project
                });                   

                 google.maps.event.addListener(marker, 'click', function() {
                    map.setCenter(myLatLng);
                    map.setZoom(8);                  
                  }); 
                markers.push(marker);

            }
            var markerCluster = new MarkerClusterer(map, markers);





            //FILTERS
            var programTitleArray=[];
            var typeTitleArray=[];
            programFilter.append('<option>Все</option>');
            typeFilter.append('<option>Все</option>');
            projectFilter.append('<option>Все</option>');
            for(var i=0;i<data.length;i++){
                var programTitle = data[i].program.title;
                if($.inArray(programTitle,programTitleArray)==-1){
                    programTitleArray.push(programTitle);
                    programFilter.append('<option>'+programTitle+'</option>');
                }  


                var types = data[i].types;
                for(var j=0;j<types.length;j++){
                    var typeTitle = types[j].title;
                    if($.inArray(typeTitle,typeTitleArray)==-1){
                        typeTitleArray.push(typeTitle);
                        typeFilter.append('<option>'+typeTitle+'</option>');
                    }
                }

                var projectTitle = data[i].title;
                projectFilter.append('<option>'+projectTitle+'</option>');                


            }

            var programFilterValue = 'Все';
            var projectFilterValue = 'Все';
            var typeFilterValue = 'Все';
            programFilter.select2().on("change", function() {
                programFilterValue=programFilter.select2("val");
                infowindow.close();
                map.setZoom(2);
                filterFunction();
            });
            projectFilter.select2().on("change", function() {
                projectFilterValue=projectFilter.select2("val");
                infowindow.close();
                map.setZoom(2);
                filterFunction();
            });
            typeFilter.select2().on("change", function() {
                typeFilterValue=typeFilter.select2("val");
                infowindow.close();
                map.setZoom(2);
                filterFunction();
            });





            //FILTER FUNCTION
            function filterFunction(){
                for (var i = 0; i<markers.length; i++) {
                    markers[i].setMap(null)
                }
                markers = [];
                markerCluster.clearMarkers();

                var bounds = map.getBounds();
                leftPart.html('');
                for(var i=0;i<data.length;i++){
                    var project = data[i];
                    var x_cord = project.lat;
                    var y_cord = project.lng;

                    var program = project.program;
                    
                    var types = project.types;
                    var typeArray=[];
                    for(var j=0;j<types.length;j++){
                        typeArray.push(types[j].title);
                    }

                    var programFilterBul;
                    if(programFilterValue == 'Все'){
                        programFilterBul=true;
                    }else{
                        programFilterBul = (programFilterValue==program.title);
                    }

                    var projectFilterBul;
                    if(projectFilterValue == 'Все'){
                        projectFilterBul=true;
                    }else{
                        projectFilterBul = (projectFilterValue==project.title);
                    }

                    var typeFilterBul;
                    if(typeFilterValue == 'Все'){
                        typeFilterBul=true;
                    }else{
                        typeFilterBul = ($.inArray(typeFilterValue,typeArray)>-1);
                    }

                    if(x_cord<=bounds.Da.j&&x_cord>=bounds.Da.k&&y_cord<=bounds.va.k&&y_cord>=bounds.va.j&&programFilterBul&&projectFilterBul&&typeFilterBul){
                        var myLatLng = new google.maps.LatLng(x_cord, y_cord);
                        var marker=new google.maps.Marker({
                                position: myLatLng,
                                title: project.title
                        });   
                         google.maps.event.addListener(marker, 'click', function() {
                            map.setCenter(myLatLng);
                            map.setZoom(8);
                          });                 
                        markers.push(marker);
                        leftPart.append('<li><a href="/site/project/'+project.id+'">'+ project.title + '</a></li>');
                    }                    
                }
                markerCluster = new MarkerClusterer(map, markers);
            }





            //LIST IN LEFT PART CHANGES DEPENDS OF MAP SIZE
            google.maps.event.addListener(map, 'bounds_changed', function() {
                // infowindow.close();
                filterFunction();
            });





        }
    });

    
});