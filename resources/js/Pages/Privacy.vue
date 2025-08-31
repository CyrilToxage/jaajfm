<template>

    <Head title="Politique de Confidentialité - JaaJ FM" />

    <div class="min-h-screen bg-gradient-to-br from-purple-600 via-orange-500 to-cyan-500">
        <!-- Formes décoratives en arrière-plan -->
        <div class="fixed inset-0 overflow-hidden pointer-events-none">
            <div class="absolute w-48 h-48 bg-cyan-400 rounded-full top-10 right-10 opacity-10 animate-float"></div>
            <div
                class="absolute w-36 h-36 bg-orange-500 transform rotate-45 bottom-20 left-15 opacity-10 animate-float-reverse">
            </div>
            <div class="absolute w-24 h-24 bg-purple-600 rounded-full top-1/2 right-30 opacity-10 animate-float"></div>
        </div>

        <!-- Version Desktop -->
        <div class="hidden md:flex min-h-screen">
            <!-- Sidebar -->
            <Sidebar />

            <!-- Contenu principal -->
            <main class="flex-1 ml-64 p-5 relative">
                <!-- Header -->
                <Header @live-radio-toggle="handleLiveRadioToggle" />

                <!-- Contenu -->
                <div class="space-y-8">
                    <!-- Section Politique de Confidentialité -->
                    <section class="glass rounded-2xl p-8">
                        <div class="flex items-center gap-4 mb-6">
                            <button @click="goBack" class="text-white hover:text-purple-300 transition-colors">
                                <ArrowLeftIcon class="w-6 h-6" />
                            </button>
                            <h1 class="text-3xl font-bold text-white">Politique de Confidentialité</h1>
                        </div>

                        <div class="prose prose-invert max-w-none">
                            <div class="text-white space-y-6">
                                <!-- Introduction -->
                                <div class="bg-white/10 rounded-xl p-6">
                                    <h2 class="text-2xl font-bold text-purple-300 mb-4">1. Introduction</h2>
                                    <p class="text-white/90 leading-relaxed mb-4">JaaJ FM s'engage à protéger la
                                        confidentialité et la sécurité de vos données personnelles. Cette politique de
                                        confidentialité explique comment nous collectons, utilisons, stockons et
                                        protégeons vos informations personnelles conformément au Règlement Général sur
                                        la Protection des Données (RGPD) et à la législation belge en vigueur.</p>
                                    <div class="bg-blue-500/20 border border-blue-500/30 rounded-lg p-4">
                                        <p class="text-blue-200 font-semibold mb-2">Informations importantes :</p>
                                        <p class="text-white/90 text-sm"><strong>Date d'entrée en vigueur :</strong> 1er
                                            septembre 2025</p>
                                        <p class="text-white/90 text-sm"><strong>Dernière mise à jour :</strong> 1er
                                            septembre 2025</p>
                                    </div>
                                </div>

                                <!-- Responsable du traitement -->
                                <div class="bg-white/10 rounded-xl p-6">
                                    <h2 class="text-2xl font-bold text-purple-300 mb-4">2. Responsable du traitement
                                    </h2>
                                    <div class="text-white/90 leading-relaxed space-y-2">
                                        <p><strong>Identité du responsable :</strong> Cyril Mignon</p>
                                        <p><strong>Qualité :</strong> Particulier, éditeur du site JaaJ FM (projet
                                            personnel non-commercial)</p>
                                        <p><strong>Localisation :</strong> Ottignies, Belgique</p>
                                        <p><strong>Email :</strong> contact@jaajfm.com</p>
                                        <p class="text-sm text-white/70 mt-3">Note : En tant que particulier gérant un
                                            site non-commercial, je ne suis pas tenu de désigner un Délégué à la
                                            Protection des Données (DPO). Les données complètes d'identification ont été
                                            transmises à l'hébergeur.</p>
                                    </div>
                                </div>

                                <!-- Données personnelles collectées -->
                                <div class="bg-white/10 rounded-xl p-6">
                                    <h2 class="text-2xl font-bold text-purple-300 mb-4">3. Données personnelles
                                        collectées</h2>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">3.1 Données d'inscription et
                                        de profil</h3>
                                    <ul class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-4">
                                        <li><strong>Nom d'utilisateur</strong> (pseudonyme choisi)</li>
                                        <li><strong>Adresse email</strong> (obligatoire pour la création de compte)</li>
                                        <li><strong>Mot de passe</strong> (crypté et sécurisé)</li>
                                        <li><strong>Date de naissance</strong> (pour vérifier l'âge minimum)</li>
                                        <li><strong>Pays de résidence</strong> (optionnel)</li>
                                        <li><strong>Photo de profil</strong> (optionnelle)</li>
                                        <li><strong>Biographie</strong> (optionnelle)</li>
                                    </ul>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">3.2 Données d'utilisation et
                                        de navigation</h3>
                                    <ul class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-4">
                                        <li><strong>Adresse IP</strong> et données de géolocalisation approximative</li>
                                        <li><strong>Informations sur votre navigateur</strong> (type, version, langue)
                                        </li>
                                        <li><strong>Système d'exploitation</strong> et type d'appareil</li>
                                        <li><strong>Pages visitées</strong> et temps passé sur le site</li>
                                        <li><strong>Actions effectuées</strong> (clics, téléchargements, partages)</li>
                                        <li><strong>Référent</strong> (site web d'où vous venez)</li>
                                        <li><strong>Horodatage</strong> des connexions et activités</li>
                                    </ul>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">3.3 Données de contenu
                                        musical</h3>
                                    <ul class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-4">
                                        <li><strong>Fichiers audio</strong> uploadés</li>
                                        <li><strong>Métadonnées musicales</strong> (titre, artiste, genre, durée, etc.)
                                        </li>
                                        <li><strong>Descriptions et commentaires</strong> associés aux créations</li>
                                        <li><strong>Tags et catégories</strong> attribués</li>
                                        <li><strong>Informations techniques</strong> sur les fichiers (format, qualité,
                                            etc.)</li>
                                    </ul>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">3.4 Données d'interaction
                                        sociale</h3>
                                    <ul class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-4">
                                        <li><strong>Likes et dislikes</strong> sur les contenus</li>
                                        <li><strong>Commentaires</strong> publiés</li>
                                        <li><strong>Messages privés</strong> échangés</li>
                                        <li><strong>Abonnements</strong> et followers</li>
                                        <li><strong>Participations aux classements</strong> et concours</li>
                                        <li><strong>Historique d'écoute</strong> et playlists</li>
                                    </ul>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">3.5 Données de communication
                                    </h3>
                                    <ul class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4">
                                        <li><strong>Emails</strong> envoyés et reçus</li>
                                        <li><strong>Messages</strong> via formulaires de contact</li>
                                        <li><strong>Signalements</strong> et réclamations</li>
                                        <li><strong>Correspondances</strong> avec notre support client</li>
                                    </ul>
                                </div>

                                <!-- Finalités du traitement -->
                                <div class="bg-white/10 rounded-xl p-6">
                                    <h2 class="text-2xl font-bold text-purple-300 mb-4">4. Finalités du traitement et
                                        bases légales</h2>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">4.1 Gestion des comptes
                                        utilisateurs</h3>
                                    <ul class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-4">
                                        <li><strong>Finalité :</strong> Création, authentification et gestion des
                                            comptes</li>
                                        <li><strong>Base légale :</strong> Exécution du contrat d'utilisation</li>
                                        <li><strong>Données concernées :</strong> Données d'inscription, mot de passe
                                        </li>
                                    </ul>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">4.2 Fourniture des services
                                    </h3>
                                    <ul class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-4">
                                        <li><strong>Finalité :</strong> Mise à disposition de la plateforme musicale
                                        </li>
                                        <li><strong>Base légale :</strong> Exécution du contrat d'utilisation</li>
                                        <li><strong>Données concernées :</strong> Toutes les données nécessaires au
                                            fonctionnement</li>
                                    </ul>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">4.3 Personnalisation de
                                        l'expérience</h3>
                                    <ul class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-4">
                                        <li><strong>Finalité :</strong> Recommandations musicales, interface
                                            personnalisée</li>
                                        <li><strong>Base légale :</strong> Consentement et intérêt légitime</li>
                                        <li><strong>Données concernées :</strong> Historique d'écoute, préférences,
                                            interactions</li>
                                    </ul>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">4.4 Communication avec les
                                        utilisateurs</h3>
                                    <ul class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-4">
                                        <li><strong>Finalité :</strong> Notifications, newsletters, support client</li>
                                        <li><strong>Base légale :</strong> Consentement ou exécution du contrat</li>
                                        <li><strong>Données concernées :</strong> Email, préférences de communication
                                        </li>
                                    </ul>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">4.5 Amélioration des services
                                    </h3>
                                    <ul class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-4">
                                        <li><strong>Finalité :</strong> Statistiques, analyses, développement de
                                            nouvelles fonctionnalités</li>
                                        <li><strong>Base légale :</strong> Intérêt légitime</li>
                                        <li><strong>Données concernées :</strong> Données d'usage anonymisées</li>
                                    </ul>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">4.6 Sécurité et prévention
                                        des abus</h3>
                                    <ul class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-4">
                                        <li><strong>Finalité :</strong> Protection contre la fraude, spam, violations
                                            des CGU</li>
                                        <li><strong>Base légale :</strong> Intérêt légitime et obligation légale</li>
                                        <li><strong>Données concernées :</strong> Logs de connexion, données d'usage
                                        </li>
                                    </ul>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">4.7 Obligations légales</h3>
                                    <ul class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4">
                                        <li><strong>Finalité :</strong> Respect des obligations légales et
                                            réglementaires</li>
                                        <li><strong>Base légale :</strong> Obligation légale</li>
                                        <li><strong>Données concernées :</strong> Données nécessaires selon les
                                            obligations</li>
                                    </ul>
                                </div>

                                <!-- Destinataires des données -->
                                <div class="bg-white/10 rounded-xl p-6">
                                    <h2 class="text-2xl font-bold text-purple-300 mb-4">5. Destinataires des données
                                    </h2>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">5.1 Destinataires internes
                                    </h3>
                                    <ul class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-4">
                                        <li><strong>Personnel autorisé</strong> de JaaJ FM ayant besoin d'accéder aux
                                            données pour leurs missions</li>
                                    </ul>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">5.2 Prestataires de services
                                        (sous-traitants)</h3>
                                    <ul class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-4">
                                        <li><strong>Hébergeur web</strong> (OVH) : stockage et mise à disposition du
                                            site</li>
                                        <li><strong>Services de CDN</strong> : diffusion optimisée du contenu musical
                                        </li>
                                        <li><strong>Services d'emailing</strong> : envoi de newsletters et notifications
                                        </li>
                                        <li><strong>Outils d'analyse</strong> : statistiques de fréquentation
                                            (anonymisées)</li>
                                        <li><strong>Prestataires de maintenance</strong> : support technique et sécurité
                                        </li>
                                    </ul>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">5.3 Partenaires tiers (avec
                                        consentement)</h3>
                                    <ul class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-4">
                                        <li><strong>Réseaux sociaux</strong> : si vous choisissez de partager du contenu
                                        </li>
                                        <li><strong>Services d'authentification tiers</strong> : si vous utilisez une
                                            connexion sociale</li>
                                        <li><strong>Plateformes de streaming</strong> : pour l'intégration de lecteurs
                                            externes</li>
                                    </ul>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">5.4 Autorités légales</h3>
                                    <ul class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4">
                                        <li><strong>Autorités judiciaires ou administratives</strong> : en cas de
                                            réquisition légale</li>
                                        <li><strong>Forces de l'ordre</strong> : dans le cadre d'enquêtes officielles
                                        </li>
                                    </ul>
                                </div>

                                <!-- Transferts internationaux -->
                                <div class="bg-white/10 rounded-xl p-6">
                                    <h2 class="text-2xl font-bold text-purple-300 mb-4">6. Transferts internationaux de
                                        données</h2>
                                    <p class="text-white/90 leading-relaxed mb-4">Certaines données peuvent être
                                        transférées vers des pays situés en dehors de l'Espace Économique Européen (EEE)
                                        dans le cadre de l'utilisation de services tiers.</p>

                                    <div class="bg-yellow-500/20 border border-yellow-500/30 rounded-lg p-4 mb-4">
                                        <p class="text-yellow-200 font-semibold mb-2">Note importante :</p>
                                        <p class="text-white/90 text-sm">JaaJ FM ne stocke aucune information vous
                                            concernant dans une base de données externe non sécurisée. Vos informations
                                            personnelles seront utilisées uniquement pour répondre à votre demande et
                                            pour le fonctionnement du service.</p>
                                    </div>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">6.1 Garanties mises en place
                                    </h3>
                                    <ul class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-4">
                                        <li><strong>Clauses contractuelles types</strong> de la Commission européenne
                                        </li>
                                        <li><strong>Décisions d'adéquation</strong> pour certains pays</li>
                                        <li><strong>Certifications</strong> et codes de conduite appropriés</li>
                                        <li><strong>Mesures de protection supplémentaires</strong> si nécessaire</li>
                                    </ul>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">6.2 Principaux transferts
                                    </h3>
                                    <ul class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4">
                                        <li><strong>États-Unis</strong> : Services cloud et analytiques (avec garanties
                                            Privacy Shield successeur ou clauses contractuelles)</li>
                                        <li><strong>Autres pays tiers</strong> : Uniquement avec garanties appropriées
                                        </li>
                                    </ul>
                                </div>

                                <!-- Durée de conservation -->
                                <div class="bg-white/10 rounded-xl p-6">
                                    <h2 class="text-2xl font-bold text-purple-300 mb-4">7. Durée de conservation</h2>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">7.1 Comptes actifs</h3>
                                    <ul class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-4">
                                        <li><strong>Données de profil</strong> : Pendant toute la durée d'utilisation du
                                            service</li>
                                        <li><strong>Contenu musical</strong> : Jusqu'à suppression par l'utilisateur
                                        </li>
                                        <li><strong>Interactions sociales</strong> : Pendant la durée de vie du compte
                                        </li>
                                    </ul>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">7.2 Comptes inactifs</h3>
                                    <ul class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-4">
                                        <li><strong>Suppression automatique</strong> après 3 ans d'inactivité</li>
                                        <li><strong>Notification préalable</strong> 6 mois avant la suppression</li>
                                        <li><strong>Possibilité de réactivation</strong> sur demande</li>
                                    </ul>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">7.3 Données supprimées</h3>
                                    <ul class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-4">
                                        <li><strong>Données de navigation</strong> : 13 mois maximum</li>
                                        <li><strong>Logs de sécurité</strong> : 1 an maximum</li>
                                        <li><strong>Données de sauvegarde</strong> : 1 an après suppression du compte
                                            principal</li>
                                    </ul>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">7.4 Conservation légale</h3>
                                    <p class="text-white/90 leading-relaxed">Certaines données peuvent être conservées
                                        plus longtemps pour respecter nos obligations légales (comptables, fiscales,
                                        etc.).</p>
                                </div>

                                <!-- Vos droits (RGPD) -->
                                <div class="bg-white/10 rounded-xl p-6">
                                    <h2 class="text-2xl font-bold text-purple-300 mb-4">8. Vos droits (RGPD)</h2>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">8.1 Droit d'accès (Article 15
                                        RGPD)</h3>
                                    <p class="text-white/90 leading-relaxed mb-4">Vous pouvez demander à connaître
                                        quelles données nous détenons sur vous, leur origine, leur utilisation et les
                                        destinataires.</p>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">8.2 Droit de rectification
                                        (Article 16 RGPD)</h3>
                                    <p class="text-white/90 leading-relaxed mb-4">Vous pouvez demander la correction de
                                        données inexactes ou incomplètes vous concernant.</p>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">8.3 Droit à l'effacement
                                        (Article 17 RGPD)</h3>
                                    <p class="text-white/90 leading-relaxed mb-3">Vous pouvez demander la suppression de
                                        vos données dans certains cas :</p>
                                    <ul class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-4">
                                        <li>Les données ne sont plus nécessaires</li>
                                        <li>Vous retirez votre consentement</li>
                                        <li>Vos données ont fait l'objet d'un traitement illicite</li>
                                        <li>L'effacement est requis pour respecter une obligation légale</li>
                                    </ul>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">8.4 Droit à la limitation du
                                        traitement (Article 18 RGPD)</h3>
                                    <p class="text-white/90 leading-relaxed mb-3">Vous pouvez demander la limitation du
                                        traitement dans certains cas :</p>
                                    <ul class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-4">
                                        <li>Vous contestez l'exactitude des données</li>
                                        <li>Le traitement est illicite mais vous vous opposez à l'effacement</li>
                                        <li>Nous n'avons plus besoin des données mais vous en avez besoin pour une
                                            réclamation</li>
                                    </ul>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">8.5 Droit à la portabilité
                                        (Article 20 RGPD)</h3>
                                    <p class="text-white/90 leading-relaxed mb-4">Vous pouvez récupérer vos données dans
                                        un format structuré et lisible par machine pour les transmettre à un autre
                                        responsable de traitement.</p>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">8.6 Droit d'opposition
                                        (Article 21 RGPD)</h3>
                                    <p class="text-white/90 leading-relaxed mb-4">Vous pouvez vous opposer au traitement
                                        de vos données pour des raisons tenant à votre situation particulière, notamment
                                        pour le marketing direct.</p>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">8.7 Droit de retrait du
                                        consentement</h3>
                                    <p class="text-white/90 leading-relaxed mb-4">Vous pouvez retirer votre consentement
                                        à tout moment pour les traitements basés sur cette base légale.</p>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">8.8 Exercice de vos droits
                                    </h3>
                                    <p class="text-white/90 leading-relaxed mb-3">Pour exercer vos droits, contactez-moi
                                        :</p>
                                    <div class="bg-blue-500/20 border border-blue-500/30 rounded-lg p-4 mb-4">
                                        <p class="text-blue-200 font-semibold mb-2">Contact :</p>
                                        <p class="text-white/90 text-sm"><strong>Email :</strong> contact@jaajfm.com</p>
                                        <p class="text-white/90 text-sm"><strong>Délai de réponse :</strong> 1 mois
                                            maximum</p>
                                        <p class="text-white/90 text-sm"><strong>Justificatif d'identité :</strong>
                                            Requis pour la sécurité</p>
                                        <p class="text-white/90 text-sm">Note : En tant que particulier, je traiterai
                                            personnellement votre demande dans les meilleurs délais.</p>
                                    </div>
                                </div>

                                <!-- Sécurité des données -->
                                <div class="bg-white/10 rounded-xl p-6">
                                    <h2 class="text-2xl font-bold text-purple-300 mb-4">9. Sécurité des données</h2>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">9.1 Mesures techniques</h3>
                                    <ul class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-4">
                                        <li><strong>Chiffrement</strong> des données sensibles (HTTPS, SSL/TLS)</li>
                                        <li><strong>Protection email</strong> : Les données stockées dans ma boîte mail
                                            sont protégées par un mot de passe et les informations envoyées sont
                                            protégées par un encryptage SSL</li>
                                        <li><strong>Hachage</strong> des mots de passe (algorithmes sécurisés)</li>
                                        <li><strong>Pare-feu</strong> et systèmes de détection d'intrusion</li>
                                        <li><strong>Sauvegardes</strong> régulières et chiffrées</li>
                                        <li><strong>Mises à jour de sécurité</strong> régulières</li>
                                    </ul>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">9.2 Mesures
                                        organisationnelles</h3>
                                    <ul class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-4">
                                        <li><strong>Accès restreint</strong> aux données personnelles</li>
                                        <li><strong>Formation</strong> du personnel sur la protection des données</li>
                                        <li><strong>Procédures</strong> de sécurité et de gestion des incidents</li>
                                        <li><strong>Audits de sécurité</strong> réguliers</li>
                                        <li><strong>Contractualisation</strong> avec les sous-traitants</li>
                                    </ul>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">9.3 Notification des
                                        violations</h3>
                                    <p class="text-white/90 leading-relaxed">En cas de violation de données personnelles
                                        susceptible d'engendrer un risque élevé pour vos droits et libertés, nous vous
                                        en informerons dans les 72 heures conformément au RGPD.</p>
                                </div>

                                <!-- Cookies et technologies similaires -->
                                <div class="bg-white/10 rounded-xl p-6">
                                    <h2 class="text-2xl font-bold text-purple-300 mb-4">10. Cookies et technologies
                                        similaires</h2>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">10.1 Types de cookies
                                        utilisés</h3>

                                    <h4 class="text-lg font-semibold text-purple-100 mb-2">Cookies strictement
                                        nécessaires (exemptés de consentement)</h4>
                                    <ul class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-4">
                                        <li><strong>Authentification</strong> : Maintien de la session utilisateur</li>
                                        <li><strong>Sécurité</strong> : Protection contre les attaques CSRF</li>
                                        <li><strong>Fonctionnement</strong> : Panier, préférences de langue</li>
                                    </ul>

                                    <h4 class="text-lg font-semibold text-purple-100 mb-2">Cookies de performance (avec
                                        consentement)</h4>
                                    <ul class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-4">
                                        <li><strong>Analytics</strong> : Google Analytics, mesures d'audience</li>
                                        <li><strong>Performance</strong> : Optimisation du temps de chargement</li>
                                        <li><strong>Erreurs</strong> : Détection et correction des bugs</li>
                                    </ul>

                                    <h4 class="text-lg font-semibold text-purple-100 mb-2">Cookies de personnalisation
                                        (avec consentement)</h4>
                                    <ul class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-4">
                                        <li><strong>Préférences</strong> : Recommandations musicales</li>
                                        <li><strong>Interface</strong> : Thème, disposition personnalisée</li>
                                        <li><strong>Historique</strong> : Dernières écoutes et recherches</li>
                                    </ul>

                                    <h4 class="text-lg font-semibold text-purple-100 mb-2">Cookies publicitaires (avec
                                        consentement)</h4>
                                    <ul class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-4">
                                        <li><strong>Ciblage</strong> : Publicités personnalisées</li>
                                        <li><strong>Remarketing</strong> : Suivi des conversions</li>
                                        <li><strong>Partenaires</strong> : Réseaux publicitaires tiers</li>
                                    </ul>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">10.2 Gestion des cookies</h3>
                                    <ul class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-4">
                                        <li><strong>Bandeau de consentement</strong> au premier accès</li>
                                        <li><strong>Centre de préférences</strong> accessible à tout moment</li>
                                        <li><strong>Paramètres du navigateur</strong> pour un contrôle global</li>
                                        <li><strong>Retrait du consentement</strong> possible à tout moment</li>
                                    </ul>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">10.3 Durée de vie des cookies
                                    </h3>
                                    <ul class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4">
                                        <li><strong>Cookies de session</strong> : Supprimés à la fermeture du navigateur
                                        </li>
                                        <li><strong>Cookies persistants</strong> : 13 mois maximum</li>
                                        <li><strong>Cookies analytiques</strong> : 26 mois maximum pour Google Analytics
                                        </li>
                                    </ul>
                                </div>

                                <!-- Données des mineurs -->
                                <div class="bg-white/10 rounded-xl p-6">
                                    <h2 class="text-2xl font-bold text-purple-300 mb-4">11. Données des mineurs</h2>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">11.1 Âge minimum</h3>
                                    <p class="text-white/90 leading-relaxed mb-4">L'utilisation de JaaJ FM est autorisée
                                        aux personnes de 13 ans et plus, conformément à l'article 8 du RGPD.</p>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">11.2 Consentement parental
                                    </h3>
                                    <ul class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-4">
                                        <li><strong>13-16 ans</strong> : Consentement parental requis</li>
                                        <li><strong>Vérification</strong> : Mécanismes de contrôle de l'âge</li>
                                        <li><strong>Protection spéciale</strong> : Traitement adapté aux mineurs</li>
                                    </ul>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">11.3 Droits des parents</h3>
                                    <p class="text-white/90 leading-relaxed">Les parents peuvent exercer les droits RGPD
                                        au nom de leur enfant mineur.</p>
                                </div>

                                <!-- Modifications de la politique -->
                                <div class="bg-white/10 rounded-xl p-6">
                                    <h2 class="text-2xl font-bold text-purple-300 mb-4">12. Modifications de la
                                        politique</h2>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">12.1 Notification des
                                        changements</h3>
                                    <ul class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-4">
                                        <li><strong>Notification par email</strong> pour les changements importants</li>
                                        <li><strong>Bannière d'information</strong> sur le site</li>
                                        <li><strong>Historique des versions</strong> disponible sur demande</li>
                                    </ul>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">12.2 Acceptation des
                                        modifications</h3>
                                    <p class="text-white/90 leading-relaxed">La poursuite de l'utilisation du service
                                        après modification vaut acceptation de la nouvelle politique.</p>
                                </div>

                                <!-- Contact et réclamations -->
                                <div class="bg-white/10 rounded-xl p-6">
                                    <h2 class="text-2xl font-bold text-purple-300 mb-4">13. Contact et réclamations</h2>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">13.1 Contact pour les
                                        questions de confidentialité</h3>
                                    <div class="bg-blue-500/20 border border-blue-500/30 rounded-lg p-4 mb-4">
                                        <p class="text-blue-200 font-semibold mb-2">Email :</p>
                                        <p class="text-white/90 text-sm">contact@jaajfm.com</p>
                                        <p class="text-white/90 text-sm mt-2">Note : En tant que particulier gérant ce
                                            site, je m'engage à traiter personnellement vos demandes dans le respect de
                                            la réglementation.</p>
                                    </div>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">13.2 Médiation</h3>
                                    <p class="text-white/90 leading-relaxed">Avant toute saisine d'une autorité, nous
                                        vous encourageons à nous contacter directement pour résoudre amiablement tout
                                        différend.</p>
                                </div>

                                <!-- Législation applicable -->
                                <div class="bg-white/10 rounded-xl p-6">
                                    <h2 class="text-2xl font-bold text-purple-300 mb-4">14. Législation applicable</h2>
                                    <p class="text-white/90 leading-relaxed mb-4">Cette politique de confidentialité est
                                        régie par :</p>
                                    <ul class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-4">
                                        <li>Le <strong>Règlement Général sur la Protection des Données</strong> (RGPD)
                                            2016/679</li>
                                        <li>La <strong>loi belge du 30 juillet 2018</strong> relative à la protection
                                            des personnes physiques</li>
                                        <li>Le <strong>Code de droit économique belge</strong></li>
                                        <li>Toute autre réglementation applicable en Belgique</li>
                                    </ul>

                                    <div class="bg-green-500/20 border border-green-500/30 rounded-lg p-4">
                                        <p class="text-green-200 font-semibold mb-2">Informations finales :</p>
                                        <p class="text-white/90 text-sm"><strong>Dernière mise à jour :</strong> 1er
                                            septembre 2025</p>
                                        <p class="text-white/90 text-sm"><strong>Version :</strong> 1.0</p>
                                        <p class="text-white/90 text-sm mt-2"><strong>Pour toute question concernant
                                                cette politique, contactez-nous à :</strong> contact@jaajfm.com</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </main>
        </div>

        <!-- Version Mobile -->
        <div class="md:hidden">
            <!-- Header Mobile -->
            <MobilePageHeader title="Politique de Confidentialité" />

            <!-- Contenu Mobile -->
            <main class="pt-20 pb-20">
                <div class="px-4 py-6 space-y-6">
                    <!-- Section Politique de Confidentialité -->
                    <section class="glass rounded-2xl p-6">
                        <div class="flex items-center gap-4 mb-6">
                            <button @click="goBack" class="text-white hover:text-purple-300 transition-colors">
                                <ArrowLeftIcon class="w-5 h-5" />
                            </button>
                            <h1 class="text-2xl font-bold text-white">Politique de Confidentialité</h1>
                        </div>

                        <div class="prose prose-invert max-w-none">
                            <div class="text-white space-y-6">
                                <!-- Introduction -->
                                <div class="bg-white/10 rounded-xl p-4">
                                    <h2 class="text-xl font-bold text-purple-300 mb-3">1. Introduction</h2>
                                    <p class="text-white/90 leading-relaxed mb-3 text-sm">JaaJ FM s'engage à protéger la
                                        confidentialité et la sécurité de vos données personnelles. Cette politique de
                                        confidentialité explique comment nous collectons, utilisons, stockons et
                                        protégeons vos informations personnelles conformément au Règlement Général sur
                                        la Protection des Données (RGPD) et à la législation belge en vigueur.</p>
                                    <div class="bg-blue-500/20 border border-blue-500/30 rounded-lg p-3">
                                        <p class="text-blue-200 font-semibold mb-1 text-sm">Informations importantes :
                                        </p>
                                        <p class="text-white/90 text-xs"><strong>Date d'entrée en vigueur :</strong> 1er
                                            septembre 2025</p>
                                        <p class="text-white/90 text-xs"><strong>Dernière mise à jour :</strong> 1er
                                            septembre 2025</p>
                                    </div>
                                </div>

                                <!-- Responsable du traitement -->
                                <div class="bg-white/10 rounded-xl p-4">
                                    <h2 class="text-xl font-bold text-purple-300 mb-3">2. Responsable du traitement</h2>
                                    <div class="text-white/90 leading-relaxed space-y-2 text-sm">
                                        <p><strong>Identité du responsable :</strong> Cyril Mignon</p>
                                        <p><strong>Qualité :</strong> Particulier, éditeur du site JaaJ FM (projet
                                            personnel non-commercial)</p>
                                        <p><strong>Localisation :</strong> Ottignies, Belgique</p>
                                        <p><strong>Email :</strong> contact@jaajfm.com</p>
                                        <p class="text-xs text-white/70 mt-3">Note : En tant que particulier gérant un
                                            site non-commercial, je ne suis pas tenu de désigner un Délégué à la
                                            Protection des Données (DPO). Les données complètes d'identification ont été
                                            transmises à l'hébergeur.</p>
                                    </div>
                                </div>

                                <!-- Données personnelles collectées -->
                                <div class="bg-white/10 rounded-xl p-4">
                                    <h2 class="text-xl font-bold text-purple-300 mb-3">3. Données personnelles
                                        collectées</h2>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">3.1 Données d'inscription et
                                        de profil</h3>
                                    <ul
                                        class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-3 text-sm">
                                        <li><strong>Nom d'utilisateur</strong> (pseudonyme choisi)</li>
                                        <li><strong>Adresse email</strong> (obligatoire pour la création de compte)</li>
                                        <li><strong>Mot de passe</strong> (crypté et sécurisé)</li>
                                        <li><strong>Date de naissance</strong> (pour vérifier l'âge minimum)</li>
                                        <li><strong>Pays de résidence</strong> (optionnel)</li>
                                        <li><strong>Photo de profil</strong> (optionnelle)</li>
                                        <li><strong>Biographie</strong> (optionnelle)</li>
                                    </ul>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">3.2 Données d'utilisation et
                                        de navigation</h3>
                                    <ul
                                        class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-3 text-sm">
                                        <li><strong>Adresse IP</strong> et données de géolocalisation approximative</li>
                                        <li><strong>Informations sur votre navigateur</strong> (type, version, langue)
                                        </li>
                                        <li><strong>Système d'exploitation</strong> et type d'appareil</li>
                                        <li><strong>Pages visitées</strong> et temps passé sur le site</li>
                                        <li><strong>Actions effectuées</strong> (clics, téléchargements, partages)</li>
                                        <li><strong>Référent</strong> (site web d'où vous venez)</li>
                                        <li><strong>Horodatage</strong> des connexions et activités</li>
                                    </ul>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">3.3 Données de contenu
                                        musical</h3>
                                    <ul
                                        class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-3 text-sm">
                                        <li><strong>Fichiers audio</strong> uploadés</li>
                                        <li><strong>Métadonnées musicales</strong> (titre, artiste, genre, durée, etc.)
                                        </li>
                                        <li><strong>Descriptions et commentaires</strong> associés aux créations</li>
                                        <li><strong>Tags et catégories</strong> attribués</li>
                                        <li><strong>Informations techniques</strong> sur les fichiers (format, qualité,
                                            etc.)</li>
                                    </ul>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">3.4 Données d'interaction
                                        sociale</h3>
                                    <ul
                                        class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-3 text-sm">
                                        <li><strong>Likes et dislikes</strong> sur les contenus</li>
                                        <li><strong>Commentaires</strong> publiés</li>
                                        <li><strong>Messages privés</strong> échangés</li>
                                        <li><strong>Abonnements</strong> et followers</li>
                                        <li><strong>Participations aux classements</strong> et concours</li>
                                        <li><strong>Historique d'écoute</strong> et playlists</li>
                                    </ul>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">3.5 Données de communication
                                    </h3>
                                    <ul
                                        class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 text-sm">
                                        <li><strong>Emails</strong> envoyés et reçus</li>
                                        <li><strong>Messages</strong> via formulaires de contact</li>
                                        <li><strong>Signalements</strong> et réclamations</li>
                                        <li><strong>Correspondances</strong> avec notre support client</li>
                                    </ul>
                                </div>

                                <!-- Finalités du traitement -->
                                <div class="bg-white/10 rounded-xl p-4">
                                    <h2 class="text-xl font-bold text-purple-300 mb-3">4. Finalités du traitement et
                                        bases légales</h2>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">4.1 Gestion des comptes
                                        utilisateurs</h3>
                                    <ul
                                        class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-3 text-sm">
                                        <li><strong>Finalité :</strong> Création, authentification et gestion des
                                            comptes</li>
                                        <li><strong>Base légale :</strong> Exécution du contrat d'utilisation</li>
                                        <li><strong>Données concernées :</strong> Données d'inscription, mot de passe
                                        </li>
                                    </ul>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">4.2 Fourniture des services
                                    </h3>
                                    <ul
                                        class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-3 text-sm">
                                        <li><strong>Finalité :</strong> Mise à disposition de la plateforme musicale
                                        </li>
                                        <li><strong>Base légale :</strong> Exécution du contrat d'utilisation</li>
                                        <li><strong>Données concernées :</strong> Toutes les données nécessaires au
                                            fonctionnement</li>
                                    </ul>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">4.3 Personnalisation de
                                        l'expérience</h3>
                                    <ul
                                        class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-3 text-sm">
                                        <li><strong>Finalité :</strong> Recommandations musicales, interface
                                            personnalisée</li>
                                        <li><strong>Base légale :</strong> Consentement et intérêt légitime</li>
                                        <li><strong>Données concernées :</strong> Historique d'écoute, préférences,
                                            interactions</li>
                                    </ul>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">4.4 Communication avec les
                                        utilisateurs</h3>
                                    <ul
                                        class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-3 text-sm">
                                        <li><strong>Finalité :</strong> Notifications, newsletters, support client</li>
                                        <li><strong>Base légale :</strong> Consentement ou exécution du contrat</li>
                                        <li><strong>Données concernées :</strong> Email, préférences de communication
                                        </li>
                                    </ul>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">4.5 Amélioration des services
                                    </h3>
                                    <ul
                                        class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-3 text-sm">
                                        <li><strong>Finalité :</strong> Statistiques, analyses, développement de
                                            nouvelles fonctionnalités</li>
                                        <li><strong>Base légale :</strong> Intérêt légitime</li>
                                        <li><strong>Données concernées :</strong> Données d'usage anonymisées</li>
                                    </ul>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">4.6 Sécurité et prévention
                                        des abus</h3>
                                    <ul
                                        class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-3 text-sm">
                                        <li><strong>Finalité :</strong> Protection contre la fraude, spam, violations
                                            des CGU</li>
                                        <li><strong>Base légale :</strong> Intérêt légitime et obligation légale</li>
                                        <li><strong>Données concernées :</strong> Logs de connexion, données d'usage
                                        </li>
                                    </ul>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">4.7 Obligations légales</h3>
                                    <ul
                                        class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 text-sm">
                                        <li><strong>Finalité :</strong> Respect des obligations légales et
                                            réglementaires</li>
                                        <li><strong>Base légale :</strong> Obligation légale</li>
                                        <li><strong>Données concernées :</strong> Données nécessaires selon les
                                            obligations</li>
                                    </ul>
                                </div>

                                <!-- Destinataires des données -->
                                <div class="bg-white/10 rounded-xl p-4">
                                    <h2 class="text-xl font-bold text-purple-300 mb-3">5. Destinataires des données</h2>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">5.1 Destinataires internes
                                    </h3>
                                    <ul
                                        class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-3 text-sm">
                                        <li><strong>Personnel autorisé</strong> de JaaJ FM ayant besoin d'accéder aux
                                            données pour leurs missions</li>
                                    </ul>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">5.2 Prestataires de services
                                        (sous-traitants)</h3>
                                    <ul
                                        class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-3 text-sm">
                                        <li><strong>Hébergeur web</strong> (OVH) : stockage et mise à disposition du
                                            site</li>
                                        <li><strong>Services de CDN</strong> : diffusion optimisée du contenu musical
                                        </li>
                                        <li><strong>Services d'emailing</strong> : envoi de newsletters et notifications
                                        </li>
                                        <li><strong>Outils d'analyse</strong> : statistiques de fréquentation
                                            (anonymisées)</li>
                                        <li><strong>Prestataires de maintenance</strong> : support technique et sécurité
                                        </li>
                                    </ul>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">5.3 Partenaires tiers (avec
                                        consentement)</h3>
                                    <ul
                                        class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-3 text-sm">
                                        <li><strong>Réseaux sociaux</strong> : si vous choisissez de partager du contenu
                                        </li>
                                        <li><strong>Services d'authentification tiers</strong> : si vous utilisez une
                                            connexion sociale</li>
                                        <li><strong>Plateformes de streaming</strong> : pour l'intégration de lecteurs
                                            externes</li>
                                    </ul>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">5.4 Autorités légales</h3>
                                    <ul
                                        class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 text-sm">
                                        <li><strong>Autorités judiciaires ou administratives</strong> : en cas de
                                            réquisition légale</li>
                                        <li><strong>Forces de l'ordre</strong> : dans le cadre d'enquêtes officielles
                                        </li>
                                    </ul>
                                </div>

                                <!-- Transferts internationaux -->
                                <div class="bg-white/10 rounded-xl p-4">
                                    <h2 class="text-xl font-bold text-purple-300 mb-3">6. Transferts internationaux de
                                        données</h2>
                                    <p class="text-white/90 leading-relaxed mb-3 text-sm">Certaines données peuvent être
                                        transférées vers des pays situés en dehors de l'Espace Économique Européen (EEE)
                                        dans le cadre de l'utilisation de services tiers.</p>

                                    <div class="bg-yellow-500/20 border border-yellow-500/30 rounded-lg p-3 mb-3">
                                        <p class="text-yellow-200 font-semibold mb-1 text-sm">Note importante :</p>
                                        <p class="text-white/90 text-xs">JaaJ FM ne stocke aucune information vous
                                            concernant dans une base de données externe non sécurisée. Vos informations
                                            personnelles seront utilisées uniquement pour répondre à votre demande et
                                            pour le fonctionnement du service.</p>
                                    </div>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">6.1 Garanties mises en place
                                    </h3>
                                    <ul
                                        class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-3 text-sm">
                                        <li><strong>Clauses contractuelles types</strong> de la Commission européenne
                                        </li>
                                        <li><strong>Décisions d'adéquation</strong> pour certains pays</li>
                                        <li><strong>Certifications</strong> et codes de conduite appropriés</li>
                                        <li><strong>Mesures de protection supplémentaires</strong> si nécessaire</li>
                                    </ul>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">6.2 Principaux transferts
                                    </h3>
                                    <ul
                                        class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 text-sm">
                                        <li><strong>États-Unis</strong> : Services cloud et analytiques (avec garanties
                                            Privacy Shield successeur ou clauses contractuelles)</li>
                                        <li><strong>Autres pays tiers</strong> : Uniquement avec garanties appropriées
                                        </li>
                                    </ul>
                                </div>

                                <!-- Durée de conservation -->
                                <div class="bg-white/10 rounded-xl p-4">
                                    <h2 class="text-xl font-bold text-purple-300 mb-3">7. Durée de conservation</h2>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">7.1 Comptes actifs</h3>
                                    <ul
                                        class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-3 text-sm">
                                        <li><strong>Données de profil</strong> : Pendant toute la durée d'utilisation du
                                            service</li>
                                        <li><strong>Contenu musical</strong> : Jusqu'à suppression par l'utilisateur
                                        </li>
                                        <li><strong>Interactions sociales</strong> : Pendant la durée de vie du compte
                                        </li>
                                    </ul>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">7.2 Comptes inactifs</h3>
                                    <ul
                                        class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-3 text-sm">
                                        <li><strong>Suppression automatique</strong> après 3 ans d'inactivité</li>
                                        <li><strong>Notification préalable</strong> 6 mois avant la suppression</li>
                                        <li><strong>Possibilité de réactivation</strong> sur demande</li>
                                    </ul>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">7.3 Données supprimées</h3>
                                    <ul
                                        class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-3 text-sm">
                                        <li><strong>Données de navigation</strong> : 13 mois maximum</li>
                                        <li><strong>Logs de sécurité</strong> : 1 an maximum</li>
                                        <li><strong>Données de sauvegarde</strong> : 1 an après suppression du compte
                                            principal</li>
                                    </ul>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">7.4 Conservation légale</h3>
                                    <p class="text-white/90 leading-relaxed text-sm">Certaines données peuvent être
                                        conservées plus longtemps pour respecter nos obligations légales (comptables,
                                        fiscales, etc.).</p>
                                </div>

                                <!-- Vos droits (RGPD) -->
                                <div class="bg-white/10 rounded-xl p-4">
                                    <h2 class="text-xl font-bold text-purple-300 mb-3">8. Vos droits (RGPD)</h2>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">8.1 Droit d'accès (Article 15
                                        RGPD)</h3>
                                    <p class="text-white/90 leading-relaxed mb-3 text-sm">Vous pouvez demander à
                                        connaître quelles données nous détenons sur vous, leur origine, leur utilisation
                                        et les destinataires.</p>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">8.2 Droit de rectification
                                        (Article 16 RGPD)</h3>
                                    <p class="text-white/90 leading-relaxed mb-3 text-sm">Vous pouvez demander la
                                        correction de données inexactes ou incomplètes vous concernant.</p>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">8.3 Droit à l'effacement
                                        (Article 17 RGPD)</h3>
                                    <p class="text-white/90 leading-relaxed mb-2 text-sm">Vous pouvez demander la
                                        suppression de vos données dans certains cas :</p>
                                    <ul
                                        class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-3 text-sm">
                                        <li>Les données ne sont plus nécessaires</li>
                                        <li>Vous retirez votre consentement</li>
                                        <li>Vos données ont fait l'objet d'un traitement illicite</li>
                                        <li>L'effacement est requis pour respecter une obligation légale</li>
                                    </ul>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">8.4 Droit à la limitation du
                                        traitement (Article 18 RGPD)</h3>
                                    <p class="text-white/90 leading-relaxed mb-2 text-sm">Vous pouvez demander la
                                        limitation du traitement dans certains cas :</p>
                                    <ul
                                        class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-3 text-sm">
                                        <li>Vous contestez l'exactitude des données</li>
                                        <li>Le traitement est illicite mais vous vous opposez à l'effacement</li>
                                        <li>Nous n'avons plus besoin des données mais vous en avez besoin pour une
                                            réclamation</li>
                                    </ul>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">8.5 Droit à la portabilité
                                        (Article 20 RGPD)</h3>
                                    <p class="text-white/90 leading-relaxed mb-3 text-sm">Vous pouvez récupérer vos
                                        données dans un format structuré et lisible par machine pour les transmettre à
                                        un autre responsable de traitement.</p>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">8.6 Droit d'opposition
                                        (Article 21 RGPD)</h3>
                                    <p class="text-white/90 leading-relaxed mb-3 text-sm">Vous pouvez vous opposer au
                                        traitement de vos données pour des raisons tenant à votre situation
                                        particulière, notamment pour le marketing direct.</p>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">8.7 Droit de retrait du
                                        consentement</h3>
                                    <p class="text-white/90 leading-relaxed mb-3 text-sm">Vous pouvez retirer votre
                                        consentement à tout moment pour les traitements basés sur cette base légale.</p>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">8.8 Exercice de vos droits
                                    </h3>
                                    <p class="text-white/90 leading-relaxed mb-2 text-sm">Pour exercer vos droits,
                                        contactez-moi :</p>
                                    <div class="bg-blue-500/20 border border-blue-500/30 rounded-lg p-3 mb-3">
                                        <p class="text-blue-200 font-semibold mb-1 text-sm">Contact :</p>
                                        <p class="text-white/90 text-xs"><strong>Email :</strong> contact@jaajfm.com</p>
                                        <p class="text-white/90 text-xs"><strong>Délai de réponse :</strong> 1 mois
                                            maximum</p>
                                        <p class="text-white/90 text-xs"><strong>Justificatif d'identité :</strong>
                                            Requis pour la sécurité</p>
                                        <p class="text-white/90 text-xs">Note : En tant que particulier, je traiterai
                                            personnellement votre demande dans les meilleurs délais.</p>
                                    </div>
                                </div>

                                <!-- Sécurité des données -->
                                <div class="bg-white/10 rounded-xl p-4">
                                    <h2 class="text-xl font-bold text-purple-300 mb-3">9. Sécurité des données</h2>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">9.1 Mesures techniques</h3>
                                    <ul
                                        class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-3 text-sm">
                                        <li><strong>Chiffrement</strong> des données sensibles (HTTPS, SSL/TLS)</li>
                                        <li><strong>Protection email</strong> : Les données stockées dans ma boîte mail
                                            sont protégées par un mot de passe et les informations envoyées sont
                                            protégées par un encryptage SSL</li>
                                        <li><strong>Hachage</strong> des mots de passe (algorithmes sécurisés)</li>
                                        <li><strong>Pare-feu</strong> et systèmes de détection d'intrusion</li>
                                        <li><strong>Sauvegardes</strong> régulières et chiffrées</li>
                                        <li><strong>Mises à jour de sécurité</strong> régulières</li>
                                    </ul>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">9.2 Mesures
                                        organisationnelles</h3>
                                    <ul
                                        class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-3 text-sm">
                                        <li><strong>Accès restreint</strong> aux données personnelles</li>
                                        <li><strong>Formation</strong> du personnel sur la protection des données</li>
                                        <li><strong>Procédures</strong> de sécurité et de gestion des incidents</li>
                                        <li><strong>Audits de sécurité</strong> réguliers</li>
                                        <li><strong>Contractualisation</strong> avec les sous-traitants</li>
                                    </ul>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">9.3 Notification des
                                        violations</h3>
                                    <p class="text-white/90 leading-relaxed text-sm">En cas de violation de données
                                        personnelles susceptible d'engendrer un risque élevé pour vos droits et
                                        libertés, nous vous en informerons dans les 72 heures conformément au RGPD.</p>
                                </div>

                                <!-- Cookies et technologies similaires -->
                                <div class="bg-white/10 rounded-xl p-4">
                                    <h2 class="text-xl font-bold text-purple-300 mb-3">10. Cookies et technologies
                                        similaires</h2>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">10.1 Types de cookies
                                        utilisés</h3>

                                    <h4 class="text-base font-semibold text-purple-100 mb-1">Cookies strictement
                                        nécessaires (exemptés de consentement)</h4>
                                    <ul
                                        class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-3 text-sm">
                                        <li><strong>Authentification</strong> : Maintien de la session utilisateur</li>
                                        <li><strong>Sécurité</strong> : Protection contre les attaques CSRF</li>
                                        <li><strong>Fonctionnement</strong> : Panier, préférences de langue</li>
                                    </ul>

                                    <h4 class="text-base font-semibold text-purple-100 mb-1">Cookies de performance
                                        (avec consentement)</h4>
                                    <ul
                                        class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-3 text-sm">
                                        <li><strong>Analytics</strong> : Google Analytics, mesures d'audience</li>
                                        <li><strong>Performance</strong> : Optimisation du temps de chargement</li>
                                        <li><strong>Erreurs</strong> : Détection et correction des bugs</li>
                                    </ul>

                                    <h4 class="text-base font-semibold text-purple-100 mb-1">Cookies de personnalisation
                                        (avec consentement)</h4>
                                    <ul
                                        class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-3 text-sm">
                                        <li><strong>Préférences</strong> : Recommandations musicales</li>
                                        <li><strong>Interface</strong> : Thème, disposition personnalisée</li>
                                        <li><strong>Historique</strong> : Dernières écoutes et recherches</li>
                                    </ul>

                                    <h4 class="text-base font-semibold text-purple-100 mb-1">Cookies publicitaires (avec
                                        consentement)</h4>
                                    <ul
                                        class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-3 text-sm">
                                        <li><strong>Ciblage</strong> : Publicités personnalisées</li>
                                        <li><strong>Remarketing</strong> : Suivi des conversions</li>
                                        <li><strong>Partenaires</strong> : Réseaux publicitaires tiers</li>
                                    </ul>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">10.2 Gestion des cookies</h3>
                                    <ul
                                        class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-3 text-sm">
                                        <li><strong>Bandeau de consentement</strong> au premier accès</li>
                                        <li><strong>Centre de préférences</strong> accessible à tout moment</li>
                                        <li><strong>Paramètres du navigateur</strong> pour un contrôle global</li>
                                        <li><strong>Retrait du consentement</strong> possible à tout moment</li>
                                    </ul>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">10.3 Durée de vie des cookies
                                    </h3>
                                    <ul
                                        class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 text-sm">
                                        <li><strong>Cookies de session</strong> : Supprimés à la fermeture du navigateur
                                        </li>
                                        <li><strong>Cookies persistants</strong> : 13 mois maximum</li>
                                        <li><strong>Cookies analytiques</strong> : 26 mois maximum pour Google Analytics
                                        </li>
                                    </ul>
                                </div>

                                <!-- Données des mineurs -->
                                <div class="bg-white/10 rounded-xl p-4">
                                    <h2 class="text-xl font-bold text-purple-300 mb-3">11. Données des mineurs</h2>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">11.1 Âge minimum</h3>
                                    <p class="text-white/90 leading-relaxed mb-3 text-sm">L'utilisation de JaaJ FM est
                                        autorisée aux personnes de 13 ans et plus, conformément à l'article 8 du RGPD.
                                    </p>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">11.2 Consentement parental
                                    </h3>
                                    <ul
                                        class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-3 text-sm">
                                        <li><strong>13-16 ans</strong> : Consentement parental requis</li>
                                        <li><strong>Vérification</strong> : Mécanismes de contrôle de l'âge</li>
                                        <li><strong>Protection spéciale</strong> : Traitement adapté aux mineurs</li>
                                    </ul>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">11.3 Droits des parents</h3>
                                    <p class="text-white/90 leading-relaxed text-sm">Les parents peuvent exercer les
                                        droits RGPD au nom de leur enfant mineur.</p>
                                </div>

                                <!-- Modifications de la politique -->
                                <div class="bg-white/10 rounded-xl p-4">
                                    <h2 class="text-xl font-bold text-purple-300 mb-3">12. Modifications de la politique
                                    </h2>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">12.1 Notification des
                                        changements</h3>
                                    <ul
                                        class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-3 text-sm">
                                        <li><strong>Notification par email</strong> pour les changements importants</li>
                                        <li><strong>Bannière d'information</strong> sur le site</li>
                                        <li><strong>Historique des versions</strong> disponible sur demande</li>
                                    </ul>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">12.2 Acceptation des
                                        modifications</h3>
                                    <p class="text-white/90 leading-relaxed text-sm">La poursuite de l'utilisation du
                                        service après modification vaut acceptation de la nouvelle politique.</p>
                                </div>

                                <!-- Contact et réclamations -->
                                <div class="bg-white/10 rounded-xl p-4">
                                    <h2 class="text-xl font-bold text-purple-300 mb-3">13. Contact et réclamations</h2>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">13.1 Contact pour les
                                        questions de confidentialité</h3>
                                    <div class="bg-blue-500/20 border border-blue-500/30 rounded-lg p-3 mb-3">
                                        <p class="text-blue-200 font-semibold mb-1 text-sm">Email :</p>
                                        <p class="text-white/90 text-sm">contact@jaajfm.com</p>
                                        <p class="text-white/90 text-xs mt-2">Note : En tant que particulier gérant ce
                                            site, je m'engage à traiter personnellement vos demandes dans le respect de
                                            la réglementation.</p>
                                    </div>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">13.2 Médiation</h3>
                                    <p class="text-white/90 leading-relaxed text-sm">Avant toute saisine d'une autorité,
                                        nous vous encourageons à nous contacter directement pour résoudre amiablement
                                        tout différend.</p>
                                </div>

                                <!-- Législation applicable -->
                                <div class="bg-white/10 rounded-xl p-4">
                                    <h2 class="text-xl font-bold text-purple-300 mb-3">14. Législation applicable</h2>
                                    <p class="text-white/90 leading-relaxed mb-3 text-sm">Cette politique de
                                        confidentialité est régie par :</p>
                                    <ul
                                        class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-3 text-sm">
                                        <li>Le <strong>Règlement Général sur la Protection des Données</strong> (RGPD)
                                            2016/679</li>
                                        <li>La <strong>loi belge du 30 juillet 2018</strong> relative à la protection
                                            des personnes physiques</li>
                                        <li>Le <strong>Code de droit économique belge</strong></li>
                                        <li>Toute autre réglementation applicable en Belgique</li>
                                    </ul>

                                    <div class="bg-green-500/20 border border-green-500/30 rounded-lg p-3">
                                        <p class="text-green-200 font-semibold mb-1 text-sm">Informations finales :</p>
                                        <p class="text-white/90 text-xs"><strong>Dernière mise à jour :</strong> 1er
                                            septembre 2025</p>
                                        <p class="text-white/90 text-xs"><strong>Version :</strong> 1.0</p>
                                        <p class="text-white/90 text-xs mt-2"><strong>Pour toute question concernant
                                                cette politique, contactez-nous à :</strong> contact@jaajfm.com</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </main>

            <!-- Navigation Mobile -->
            <MobileNavigation />
        </div>
    </div>
</template>

<script setup>
import { Head, router } from '@inertiajs/vue3'
import { ArrowLeftIcon } from '@heroicons/vue/24/outline'
import Sidebar from '@/Components/Sidebar.vue'
import Header from '@/Components/Header.vue'
import MobilePageHeader from '@/Components/MobilePageHeader.vue'
import MobileNavigation from '@/Components/MobileNavigation.vue'

// Méthodes
const goBack = () => {
    router.visit('/')
}

const handleLiveRadioToggle = (isPlaying) => {
    // Gérer le toggle de la radio live
}
</script>

<style scoped>
.glass {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

@keyframes float {

    0%,
    100% {
        transform: translateY(0px);
    }

    50% {
        transform: translateY(-20px);
    }
}

@keyframes float-reverse {

    0%,
    100% {
        transform: translateY(0px) rotate(45deg);
    }

    50% {
        transform: translateY(20px) rotate(45deg);
    }
}

.animate-float {
    animation: float 6s ease-in-out infinite;
}

.animate-float-reverse {
    animation: float-reverse 8s ease-in-out infinite;
}
</style>
