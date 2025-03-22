

## Schéma de la base de données

# Question 1 : 

Visualiser le schéma complet ici : https://dbdiagram.io/d/67de9d2a75d75cc844100453

# Question 2 : 

1. Proposition d’ajout de relation

Utilisateur : rose03
Action : propose d’ajouter une relation entre Rose PERRET et Jean PERRET
Effets :
Une entrée est créée dans modification_proposals :
type = add_relationship
target_person_id = ID de Rose
data = { "parent_id": Jean_ID, "child_id": Rose_ID }
status = pending
Aucun changement réel dans la table relationships tant que la proposition n’est pas acceptée.

2. Proposition de modification de fiche personne

Utilisateur : marie02
Action : propose de modifier le nom de naissance de Rose PERRET
Effets :
Une entrée est créée dans modification_proposals :
type = person_update
target_person_id = ID de Rose
data = { "birth_name": "DUPONT" }
status = pending
La fiche n’est pas modifiée immédiatement.

3. Vote d’acceptation

Utilisateurs votants : jean01, marc10, marie02
Action : chacun accepte la proposition
Effets :
3 entrées créées dans proposal_votes avec vote = accept
Lorsque 3 votes positifs sont atteints :
modification_proposals.status passe à accepted
→ Si type = add_relationship : insertion réelle dans relationships
→ Si type = person_update : mise à jour réelle dans people

4. Vote de refus

Utilisateurs votants : jean01, marie02, paul20
Action : chacun refuse la proposition
Effets :
3 entrées dans proposal_votes avec vote = reject
Lorsque 3 votes négatifs sont atteints :
modification_proposals.status passe à rejected
Aucun changement dans la base principale (people ou relationships)
