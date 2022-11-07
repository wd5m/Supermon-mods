// autcomplete.js
// Author: David McAnally WD5M (Copyright) October 13, 2022
// For ham radio use only, NOT for comercial use!
// Based on examples from //jqueryui.com/autocomplete/
// Created for use with Supermon 7.1+
$( function() {
        $( "#node" ).autocomplete({
                minLength: 3,
                source: "autocomplete.php",
                focus: function( event, ui ) {
                        $( "#node" ).val( ui.item.label );
                        return false;
                },
                select: function( event, ui ) {
                        $( "#node" ).val( ui.item.label );
                        return false;
                }
        })
        .autocomplete( "instance" )._renderItem = function( table, item ) {
                return $( "<tr>" )
                        .append( "<td style='text-align:right;'>" + item.label + "</td><td style='text-align:right;white-space:nowrap;'>" + item.call + "</td><td>" + item.desc + "</td><td style='white-space:nowrap;'>" + item.qth + "</td>" )
                        .appendTo( table );
        };
} );
