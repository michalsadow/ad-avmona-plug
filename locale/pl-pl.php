<?php

return [

  'Przeslijmi.AgileDataAvmonaPlug.numberNames.0' => 'złotówki i grosze',
  'Przeslijmi.AgileDataAvmonaPlug.numberNames.3' => 'tysiące',
  'Przeslijmi.AgileDataAvmonaPlug.numberNames.6' => 'miliony',
  'Przeslijmi.AgileDataAvmonaPlug.frequency.M' => 'miesiąc',
  'Przeslijmi.AgileDataAvmonaPlug.frequency.Q' => 'kwartał',
  'Przeslijmi.AgileDataAvmonaPlug.frequency.H' => 'pół roku',
  'Przeslijmi.AgileDataAvmonaPlug.frequency.Y' => 'rok',
  'Przeslijmi.AgileDataAvmonaPlug.frequency.B' => 'na koniec',

  'Przeslijmi.AgileDataAvmonaPlug.Analysis.column.period' => 'okres',
  'Przeslijmi.AgileDataAvmonaPlug.Analysis.column.start' => 'pierwszy dzień',
  'Przeslijmi.AgileDataAvmonaPlug.Analysis.column.stop' => 'ostatni dzień',
  'Przeslijmi.AgileDataAvmonaPlug.Analysis.column.onStart' => 'kwota początkowa',
  'Przeslijmi.AgileDataAvmonaPlug.Analysis.column.inPlus' => 'zasilenia',
  'Przeslijmi.AgileDataAvmonaPlug.Analysis.column.inMinus' => 'obciążenia',
  'Przeslijmi.AgileDataAvmonaPlug.Analysis.column.onFinish' => 'kwota końcowa',

  'Przeslijmi.AgileDataAvmonaPlug.Events.column.date' => 'data',
  'Przeslijmi.AgileDataAvmonaPlug.Events.column.category' => 'kategoria',
  'Przeslijmi.AgileDataAvmonaPlug.Events.column.name' => 'zdarzenie',
  'Przeslijmi.AgileDataAvmonaPlug.Events.column.amount' => 'kwota',

  'Przeslijmi.AgileData.tabs.capitalRules' => 'kapitały',
  'Przeslijmi.AgileData.tabs.incomesRules' => 'przychody',
  'Przeslijmi.AgileData.tabs.expendituresRules' => 'koszty',

  /**
   * Operation - AddToEventsList.
   */
  'Przeslijmi.AgileDataAvmonaPlug.Operations.AddToEventsList.title' => 'dopisanie wydarzeń do analizy wolnych środków',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.AddToEventsList.fields.categorySource.name' => 'Kolumna danych z kategorią wydarzenia (nieobowiązkowe)',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.AddToEventsList.fields.categorySource.desc' => '',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.AddToEventsList.fields.nameSource.name' => 'Kolumna danych z nazwą wydarzenia',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.AddToEventsList.fields.nameSource.desc' => '',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.AddToEventsList.fields.dateSource.name' => 'Kolumna danych z datą wydarzenia',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.AddToEventsList.fields.dateSource.desc' => '',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.AddToEventsList.fields.dateAsPeriod.name' => 'w kolumnie z datą jest podawany okres, a nie data, np. `2020Q3`.',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.AddToEventsList.fields.dateAsPeriod.desc' => '',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.AddToEventsList.fields.amountSource.name' => 'Kolumna danych z kwotą wydarzenia',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.AddToEventsList.fields.amountSource.desc' => '',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.AddToEventsList.fields.numberName.name' => 'Rząd wielkości kwot',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.AddToEventsList.fields.numberName.desc' => '',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.AddToEventsList.exc.NodeIsEmptyException.nameSource' => 'Należy wypełnić pole "Kolumna danych z nazwą wydarzenia".',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.AddToEventsList.exc.NodeIsEmptyException.dateSource' => 'Należy wypełnić pole "Kolumna danych z datą wydarzenia".',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.AddToEventsList.exc.NodeIsEmptyException.amountSource' => 'Należy wypełnić pole "Kolumna danych z kwotą wydarzenia".',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.AddToEventsList.exc.NodeIsEmptyException.numberName' => 'Należy wybrać jeden z dostępnych rzędów wielkości kwot.',

  /**
   * Operation - CountAvailableMoney.
   */
  'Przeslijmi.AgileDataAvmonaPlug.Operations.CountAvailableMoney.sourceName' => 'analiza wolnych środków',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.CountAvailableMoney.title' => 'analiza wolnych środków',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.CountAvailableMoney.fields.firstDay.name' => 'Pierwszy dzień analizy',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.CountAvailableMoney.fields.firstDay.desc' => '',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.CountAvailableMoney.fields.startingAmount.name' => 'Stan środków w przeddzień analizy (w PLN)',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.CountAvailableMoney.fields.startingAmount.desc' => '',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.CountAvailableMoney.fields.frequency.name' => 'Okres jednostkowy',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.CountAvailableMoney.fields.frequency.desc' => '',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.CountAvailableMoney.fields.length.name' => 'Liczba okresów',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.CountAvailableMoney.fields.length.desc' => '',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.CountAvailableMoney.fields.numberName.name' => 'Rząd wielkości kwot',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.CountAvailableMoney.fields.numberName.desc' => '',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.CountAvailableMoney.exc.NodeIsEmptyException.numberName' => 'Należy wybrać jeden z dostępnych rzędów wielkości kwot.',

  /**
   * Operation - ForecastFinancialAgreements.
   */
  'Przeslijmi.AgileDataAvmonaPlug.Operations.ForecastFinancialAgreements.title' => 'estymacja instrumentu finansowego',

  'Przeslijmi.AgileDataAvmonaPlug.Operations.ForecastFinancialAgreements.fields.capitalRules.name' => 'Zasady analizy kapitałów',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.ForecastFinancialAgreements.fields.capitalRules.type.name' => 'zasada',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.ForecastFinancialAgreements.fields.capitalRules.frstParamType.name' => '',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.ForecastFinancialAgreements.fields.capitalRules.frstParamType.toggle' => 'W,K',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.ForecastFinancialAgreements.fields.capitalRules.frstParam.name' => 'pierwszy atrybut',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.ForecastFinancialAgreements.fields.capitalRules.scndParamType.name' => '',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.ForecastFinancialAgreements.fields.capitalRules.scndParamType.toggle' => 'W,K',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.ForecastFinancialAgreements.fields.capitalRules.scndParam.name' => 'drugi atrybut',

  'Przeslijmi.AgileDataAvmonaPlug.Operations.ForecastFinancialAgreements.fields.capitalRulesType.amount' => 'przyjmij kwotę kapiału z [1]',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.ForecastFinancialAgreements.fields.capitalRulesType.startDate' => 'przyjmij jako datę uruchomienia [1]',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.ForecastFinancialAgreements.fields.capitalRulesType.endDate' => 'przyjmij jako datę zakończenia spłat [1]',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.ForecastFinancialAgreements.fields.capitalRulesType.gracePeriod' => 'przyjmij karencję spłat [1] mies.',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.ForecastFinancialAgreements.fields.capitalRulesType.gracePeriod.frstParam.info' => 'podaj liczbę miesięcy jako liczbę naturalną',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.ForecastFinancialAgreements.fields.capitalRulesType.frequency' => 'przyjmij częstość spłat kapitału na [1]',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.ForecastFinancialAgreements.fields.capitalRulesType.frequency.frstParam.info' => 'dopuszczalne wartości: ',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.ForecastFinancialAgreements.fields.capitalRulesType.frequency.frstParam.options.M' => 'raty miesięczne',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.ForecastFinancialAgreements.fields.capitalRulesType.frequency.frstParam.options.Q' => 'raty kwartalne',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.ForecastFinancialAgreements.fields.capitalRulesType.frequency.frstParam.options.H' => 'raty półroczne',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.ForecastFinancialAgreements.fields.capitalRulesType.frequency.frstParam.options.Y' => 'raty roczne',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.ForecastFinancialAgreements.fields.capitalRulesType.frequency.frstParam.options.B' => 'spłata balonowa',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.ForecastFinancialAgreements.fields.capitalRulesType.distributionLinear' => 'przyjmij okresowe spłaty kapitału wg rozkładu liniowego',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.ForecastFinancialAgreements.fields.capitalRulesType.distributionNormal' => 'przyjmij okresowe spłaty kapitału wg rozkładu normalnego',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.ForecastFinancialAgreements.fields.capitalRulesType.distributionNormal.frstParam.info' => 'wartość oczekiwana μ - wprowadź liczbę całkowitą pomiędzy 5 (wcześnie rozpoczęte spłaty) a 15 (późno rozpoczęte spłaty)',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.ForecastFinancialAgreements.fields.capitalRulesType.distributionNormal.scndParam.info' => 'wariancja σ² - wprowadź liczbę całkowitą pomiędzy 1 (szybko spłacana umowa) a 10 (powoli spłacana umowa)',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.ForecastFinancialAgreements.fields.capitalRulesType.loss' => 'przyjmij utratę kapitału na poziomie [1]',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.ForecastFinancialAgreements.fields.capitalRulesType.loss.frstParam.info' => 'podaj wartość od 0 do 1, gdzie np. 0.03 oznacza trzy procent',

  'Przeslijmi.AgileDataAvmonaPlug.Operations.ForecastFinancialAgreements.fields.incomesRules.name' => 'Zasady analizy przychodów od kapitałów (odsetki, opłaty)',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.ForecastFinancialAgreements.fields.incomesRules.type.name' => 'zasada',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.ForecastFinancialAgreements.fields.incomesRules.frstParamType.name' => '',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.ForecastFinancialAgreements.fields.incomesRules.frstParamType.toggle' => 'W,K',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.ForecastFinancialAgreements.fields.incomesRules.frstParam.name' => 'pierwszy atrybut',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.ForecastFinancialAgreements.fields.incomesRules.scndParamType.name' => '',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.ForecastFinancialAgreements.fields.incomesRules.scndParamType.toggle' => 'W,K',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.ForecastFinancialAgreements.fields.incomesRules.scndParam.name' => 'drugi atrybut',

  'Przeslijmi.AgileDataAvmonaPlug.Operations.ForecastFinancialAgreements.fields.incomesRulesType.interestsRate' => 'przyjmij oprocentowanie na poziomie [1]',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.ForecastFinancialAgreements.fields.incomesRulesType.interestsRate.frstParam.info' => 'podaj wartość od 0 do 1, gdzie np. 0.03 oznacza będzie trzy procent',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.ForecastFinancialAgreements.fields.incomesRulesType.oneTimeFixedFee' => 'przyjmij prowizję jednorazową w wysokości [1] PLN',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.ForecastFinancialAgreements.fields.incomesRulesType.oneTimePercFee' => 'przyjmij prowizję jednorazową w wysokości [1]',

  'Przeslijmi.AgileDataAvmonaPlug.Operations.ForecastFinancialAgreements.fields.expendituresRules.name' => 'Zasady analizy przychodów od kapitałów (odsetki, opłaty)',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.ForecastFinancialAgreements.fields.expendituresRules.type.name' => 'zasada',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.ForecastFinancialAgreements.fields.expendituresRules.frstParamType.name' => '',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.ForecastFinancialAgreements.fields.expendituresRules.frstParamType.toggle' => 'W,K',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.ForecastFinancialAgreements.fields.expendituresRules.frstParam.name' => 'pierwszy atrybut',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.ForecastFinancialAgreements.fields.expendituresRules.scndParamType.name' => '',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.ForecastFinancialAgreements.fields.expendituresRules.scndParamType.toggle' => 'W,K',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.ForecastFinancialAgreements.fields.expendituresRules.scndParam.name' => 'drugi atrybut',

  'Przeslijmi.AgileDataAvmonaPlug.Operations.ForecastFinancialAgreements.fields.expendituresRulesType.feeAnnualPerc' => 'przyjmij wynagrodzenie jako procent rocznie [1] od zarządzanego portfela',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.ForecastFinancialAgreements.fields.expendituresRulesType.feeAnnualPerc.frstParam.info' => 'podaj wartość od 0 do 1, gdzie np. 0.03 oznacza będzie trzy procent',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.ForecastFinancialAgreements.fields.expendituresRulesType.feeLimitPerc' => 'przyjmij limit wynagrodzenia jako procent [1] od wartości umowy [2]',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.ForecastFinancialAgreements.fields.expendituresRulesType.feeLimitPerc.frstParam.info' => 'podaj wartość od 0 do 1, gdzie np. 0.03 oznacza będzie trzy procent',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.ForecastFinancialAgreements.fields.expendituresRulesType.feePercOfPayments' => 'przyjmij wynagrodzenie jako procent [1] od wypłat',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.ForecastFinancialAgreements.fields.expendituresRulesType.feePercOfPayments.frstParam.info' => 'podaj wartość od 0 do 1, gdzie np. 0.03 oznacza będzie trzy procent',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.ForecastFinancialAgreements.fields.expendituresRulesType.feePercOfRepayments' => 'przyjmij wynagrodzenie jako procent [1] od spłat',
  'Przeslijmi.AgileDataAvmonaPlug.Operations.ForecastFinancialAgreements.fields.expendituresRulesType.feePercOfRepayments.frstParam.info' => 'podaj wartość od 0 do 1, gdzie np. 0.03 oznacza będzie trzy procent',

  'Przeslijmi.AgileDataAvmonaPlug.Operations.ForecastFinancialAgreements.fields.filtering.name' => [ 'redirect' => 'Przeslijmi.AgileData.Operations.Mass.Filter.fields.filtering.name' ],

];


