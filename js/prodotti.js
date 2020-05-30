/**
 * Filtro. Regola la visibilità delle quantità del prodotto "Preworkout" a seconda dell'elemento
 * <input type="radio"></input> corrispondente.
 */
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

/**
 * Filtro. Regola la visibilità delle quantità del prodotto "BCAA Capsules" a seconda
 * dell'elemento <input type="radio"></input> corrispondente.
 */
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

/**
 * Filtro. Regola la visibilità delle quantità del prodotto "Protein Powder" a seconda
 * dell'elemento <input type="radio"></input> corrispondente.
 */
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

/**
 * Filtro. Regola la visibilità delle quantità del prodotto "Protein Powder 2" a seconda
 * dell'elemento <input type="radio"></input> corrispondente.
 */
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

/**
 * Filtro. Regola la visibilità delle quantità del prodotto "T-Shirt" a seconda dell'elemento
 * <input type="radio"></input> corrispondente.
 */
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