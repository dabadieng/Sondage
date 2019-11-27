<MCD>
   <entité>
      sondage
      - id
      - titre
      - date_debut
      - date_fin

      question 
      - id
      - texte

      reponse_possible
      - id
      - texte

      visiteur
      - adresseip
   </entité>

   <association>
      comporter 
      - sondage (1,N)
      - question(1,1)  
            
      proposer
      - reponse_possible(1,1)
      - question(1,N)
      
      choisir (question)
      - visiteur(1,N)
      - reponse_possible(1,N)

   </association>
</MCD>

<MLD>
    <TABLES>
            sondage
            - son_id (pk)
            - son_titre varchar
            - son_date_debut date
            - son_date_fin date

            question 
            - que_id (pk)
            - que_texte varchar
            - que_sondage (fk)

            reponse_possible
            - rep_id (pk) 
            - rep_texte varchar 
            - rep_question (fk)

            visiteur
            - vis_adresseip int

            choix
            - cho_id (pk)
            - cho_adresseip (fk)
            - cho_reponse (fk)
            - cho_question (fk)
            unique key (cho_adresseip,cho_question)
    </TABLES>
</MLD>