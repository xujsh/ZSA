//
//  SearchViewController.m
//  teaching
//
//  Created by kidliuxu on 14-4-16.
//  Copyright (c) 2014年 icesmart. All rights reserved.
//

#import "SearchViewController.h"

@interface SearchViewController ()

@end

@implementation SearchViewController

@synthesize courseUrl, inputView;

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
    UIView *searchTitleView = [[UIView alloc] initWithFrame:CGRectMake(0, 0, 200, 22)];

    UITextField *tmpInputView = [[UITextField alloc]initWithFrame:CGRectMake(0,0, 200, 22)];
    //UITextField *tmpInputView = [[UITextField alloc] init];
    //tmpInputView.frame = CGRectMake(0,0, 200, 22);
    tmpInputView.backgroundColor = [UIColor whiteColor];
    tmpInputView.placeholder = @" 输入搜索内容";
    //tmpInputView.text = @"12@qq.com";
    tmpInputView.delegate = self;
    tmpInputView.returnKeyType = UIReturnKeySearch;
    tmpInputView.font = [UIFont systemFontOfSize:15];
    [searchTitleView addSubview:tmpInputView];

    self.inputView = tmpInputView;

    [tmpInputView release];

    [self setNavTitleView:searchTitleView];

    [self initWebView];
    NSURLRequest *request =[NSURLRequest requestWithURL:self.courseUrl];
    [self.webView loadRequest:request];
}

//点击回车按钮
- (BOOL)textFieldShouldReturn:(UITextField *)textField
{
    //[self startLogin];
    [self.inputView resignFirstResponder];
    NSString *searchStr = self.inputView.text;
    [self runWebfunctionByName:@"searchfrom" inputStr:searchStr];
    //[self runWebfunctionByName:@"searchfrom"];
    return YES;
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
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
