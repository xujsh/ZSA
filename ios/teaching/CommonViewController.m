//
//  CommonViewController.m
//  teaching
//
//  Created by kidliuxu on 14-3-17.
//  Copyright (c) 2014年 icesmart. All rights reserved.
//

#import "CommonViewController.h"

@interface CommonViewController ()

@end

@implementation CommonViewController

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
    }
    return self;
}

- (id) initWithUrl:(NSURL *) url
{
    if( (self=[self init]))
    {
        self.courseUrl = url;
    }
    return self;
}

- (void)viewDidLoad
{
    [super viewDidLoad];
    [self addBackButton];
    [self initWebView];
    NSURLRequest *request =[NSURLRequest requestWithURL:self.courseUrl];
    [self.webView loadRequest:request];
}

-(BOOL) webView:(UIWebView *)webView shouldStartLoadWithRequest:(NSURLRequest *)request navigationType:(UIWebViewNavigationType)navigationType
{
    [super webView:webView shouldStartLoadWithRequest:request navigationType:navigationType];

    NSLog(@"request %@",[request URL]);

    if (navigationType == UIWebViewNavigationTypeLinkClicked)
    {

        NSURL *URL = [request URL];


        NSLog(@"NSURL %@,%@,%@,%@",[URL baseURL],[URL lastPathComponent],[URL parameterString],[URL standardizedURL]);

        NSLog(@"request url :%@",[URL scheme]);

        if ([[URL scheme] isEqualToString:@"http"])
        {
            CommonViewController *ctl = [[CommonViewController alloc]initWithUrl:[request URL] ];

            [self.navigationController pushViewController:ctl animated:YES];
            [ctl release];


        }else{

            //Not a URL
            
        }
        
        return NO;
        
    }
    
    return YES;
}

- (void) webViewDidFinishLoad:(UIWebView *)webView
{
    [super webViewDidFinishLoad:webView];
    NSString *webTitle = [self runWebfunctionByName:@"returnTitle"];//[webView stringByEvaluatingJavaScriptFromString:@"returnTitle();"];
    //NSLog(@"webtitle: %@", webTitle);
    if(![webTitle isEqualToString:@""])
    {
        [self setNavTitle:webTitle];
    }
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

/*
#pragma mark - Navigation

// In a storyboard-based application, you will often want to do a little preparation before navigation
- (void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender
{
    // Get the new view controller using [segue destinationViewController].
    // Pass the selected object to the new view controller.
}
*/

@end
