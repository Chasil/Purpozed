<p>Gratuliere <?php echo $userName; ?>,</p>

<p>Du wurdest gerade von der Organisation <?php echo $organizationName; ?> für die Übernahme der
    Tätigkeit ausgewählt.</p>

<p>Wie geht es jetzt weiter?</p>

<p>Wir haben den Ansprechpartner der Organisation gebeten, sich innerhalb der kommenden 24 Stunden per E-Mail oder
    Telefon bei Dir zu melden, um die nächsten Schritte mit Dir zu besprechen. Falls Dich der Ansprechpartner aus
    irgendwelchen Gründen nicht erreicht, versuche ihn doch bitte ebenfalls zu erreichen.</p>

<p>Das sind die Kontaktdaten des Ansprechpartners der Organisation:</p>
<p><?php echo $currentOpportunity->contact_name . ' ' . $currentOpportunity->contact_surname; ?></p>
<p>Telefon: <?php echo $currentOpportunity->contact_phone; ?></p>
<p>E-Mail: <?php echo $currentOpportunity->contact_email; ?></p>

Wir wünschen Dir einen guten Start und ganz, ganz viel Spaß bei Deiner Tätigkeit!<br/>
Dein purpozed-Team
<br/><br/>
PS: Falls Du Hilfe benötigst, freuen wir uns sehr über eine Nachricht von Dir an support@purpozed.org"