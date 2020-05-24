function controllaPreWorkout()
{
    if ($("#acquista_CX_Pre_Workout input[name=versione]:checked").val() == "25g")
    {
        $("#CX_Pre_Workout_25g").attr("hidden", false);
        $("#CX_Pre_Workout_70g").attr("hidden", true);
    }
    else
    {
        $("#CX_Pre_Workout_25g").attr("hidden", true);
        $("#CX_Pre_Workout_70g").attr("hidden", false);
    }   
}

function controllaBCAACapsules()
{
    if ($("#acquista_CX_BCAA_Capsules input[name=versione]:checked").val() == "60c")
    {
        $("#CX_BCAA_Capsules_60c").attr("hidden", false);
        $("#CX_BCAA_Capsules_200c").attr("hidden", true);
    }
    else
    {
        $("#CX_BCAA_Capsules_60c").attr("hidden", true);
        $("#CX_BCAA_Capsules_200c").attr("hidden", false);
    }  
}

function controllaProteinPowder()
{
    if ($("#acquista_CX_Protein_Powder input[name=versione]:checked").val() == "25g")
    {
        $("#CX_Protein_Powder_25g").attr("hidden", false);
        $("#CX_Protein_Powder_70g").attr("hidden", true);
    }
    else
    {
        $("#CX_Protein_Powder_25g").attr("hidden", true);
        $("#CX_Protein_Powder_70g").attr("hidden", false);
    } 
}

function controllaProteinPowder2()
{
    if ($("#acquista_CX_Protein_Powder2 input[name=versione]:checked").val() == "25g")
    {
        $("#CX_Protein_Powder2_25g").attr("hidden", false);
        $("#CX_Protein_Powder2_70g").attr("hidden", true);
    }
    else
    {
        $("#CX_Protein_Powder2_25g").attr("hidden", true);
        $("#CX_Protein_Powder2_70g").attr("hidden", false);
    } 
}

function controllaTShirt()
{
    var versione = $("#acquista_T-Shirt_Olympia input[name=versione]:checked").val();

    switch (versione)
    {
    case "XS":
        $("#T-Shirt_Olympia_XS").attr("hidden", false);
        $("#T-Shirt_Olympia_S").attr("hidden", true);
        $("#T-Shirt_Olympia_M").attr("hidden", true);
        $("#T-Shirt_Olympia_L").attr("hidden", true);
        $("#T-Shirt_Olympia_XL").attr("hidden", true);
        break;
    case "S":
        $("#T-Shirt_Olympia_XS").attr("hidden", true);
        $("#T-Shirt_Olympia_S").attr("hidden", false);
        $("#T-Shirt_Olympia_M").attr("hidden", true);
        $("#T-Shirt_Olympia_L").attr("hidden", true);
        $("#T-Shirt_Olympia_XL").attr("hidden", true);
        break;
    case "M":
        $("#T-Shirt_Olympia_XS").attr("hidden", true);
        $("#T-Shirt_Olympia_S").attr("hidden", true);
        $("#T-Shirt_Olympia_M").attr("hidden", false);
        $("#T-Shirt_Olympia_L").attr("hidden", true);
        $("#T-Shirt_Olympia_XL").attr("hidden", true);
        break;
    case "L":
        $("#T-Shirt_Olympia_XS").attr("hidden", true);
        $("#T-Shirt_Olympia_S").attr("hidden", true);
        $("#T-Shirt_Olympia_M").attr("hidden", true);
        $("#T-Shirt_Olympia_L").attr("hidden", false);
        $("#T-Shirt_Olympia_XL").attr("hidden", true);
        break;
    case "XL":
        $("#T-Shirt_Olympia_XS").attr("hidden", true);
        $("#T-Shirt_Olympia_S").attr("hidden", true);
        $("#T-Shirt_Olympia_M").attr("hidden", true);
        $("#T-Shirt_Olympia_L").attr("hidden", true);
        $("#T-Shirt_Olympia_XL").attr("hidden", false);
        break;
    }
}